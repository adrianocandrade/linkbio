<?php
namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Sandy\Segment\Segments;
use App\Models\Authactivity;
use Illuminate\Support\Facades\Auth;
use App\Models\Pixel;
use App\Payments;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use App\Models\PlanPayment;
use App\Models\Domain as Userdomain;
use App\Models\PendingPlan;
use App\Services\UserBackupService;

class SettingsController extends Controller
{
    public function index()
    {
        return view('mix::settings.index');
    }

    public function method()
    {
        $payment = new Payments;
        $payments = $payment->getInstalledMethods();

        // Save array without error
        $getItem = function ($array, $key) {
            app('config')->set('array-temp', $array);
            $key = !empty($key) ? '.' . $key : null;
            return app('config')->get('array-temp' . $key);
        };

        unset($payments['manual']);


        return view('mix::settings.sections.methods', ['payments' => $payments, 'getItem' => $getItem]);
    }

    public function planHistory()
    {
        // History
        $history = PlanPayment::where('user', $this->user->id)->orderBy('id', 'DESC')->get();

        return view('mix::settings.sections.plan-history', ['history' => $history]);
    }

    public function pendingPlan()
    {
        // Pending
        $pending = PendingPlan::where('user', $this->user->id)->orderBy('id', 'DESC')->get();

        return view('mix::settings.sections.pending-plan', ['pending' => $pending]);
    }

    public function domains()
    {
        // Get Domains for current workspace
        $workspaceId = session('active_workspace_id');

        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        $domain = Userdomain::where('workspace_id', $workspaceId)->first();

        return view('mix::settings.sections.domains', ['domain' => $domain]);
    }

    public function domainSet(Request $request)
    {
        if (!plan('settings.custom_domain')) {
            abort(404);
        }

        $workspaceId = session('active_workspace_id');

        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        $domain = Userdomain::where('workspace_id', $workspaceId)->first();
        $request->validate([
            'set_domain' => 'required'
        ]);

        if (!$domain) {
            return back()->with('error', __('Please connect a domain'));
        }

        $edit = Userdomain::find($domain->id);
        $edit->is_active = $request->set_domain;
        $edit->save();

        return back()->with('success', __('Saved successfully'));
    }

    public function domainConfigure(Request $request)
    {
        if (!plan('settings.custom_domain')) {
            abort(404);
        }
        $domain = Userdomain::where('user', $this->user->id)->first();

        $request->validate([
            'host' => 'required',
            'protocol' => 'required'
        ]);

        $valid_url = "$request->protocol://$request->host";
        $valid_url = strtolower($valid_url);
        if (!validate_url($valid_url)) {
            return back()->with('error', __('Domain is not valid'));
        }

        if (!$domain) {
            $create = new Userdomain;
            $create->user = $this->user->id;
            $create->is_active = 0;
            $create->scheme = $request->protocol;
            $create->host = parse($valid_url, 'host');
            $create->save();

            return back()->with('success', __('Domain connected successfully'));
        }


        $edit = Userdomain::find($domain->id);
        $edit->scheme = $request->protocol;
        $edit->host = parse($valid_url, 'host');
        $edit->save();

        return back()->with('success', __('Domain edited successfully'));
    }

    public function theme()
    {
        return view('mix::settings.sections.theme');
    }

    public function themePost(Request $request)
    {
        if (!$config = \BioStyle::config($request->theme)) {
            abort(404);
        }

        // Get active workspace
        $workspaceId = session('active_workspace_id');
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        if (!$workspaceId) {
            return back()->with('error', __('Workspace not found'));
        }

        $workspace = \App\Models\Workspace::find($workspaceId);


        $workspace->theme = $request->theme;

        if (ao($config, 'defaults.enable')) {
            // Colors
            $color = $workspace->color ?? [];
            $color['button_background'] = ao($config, 'defaults.color.button_background');
            $color['button_color'] = ao($config, 'defaults.color.button_text_color');
            $color['text'] = ao($config, 'defaults.color.text_color');
            $workspace->color = $color;

            // Font
            $workspace->font = ao($config, 'defaults.font');

            // Settings

            $settings = $workspace->settings ?? [];
            $settings['radius'] = ao($config, 'defaults.radius');
            $settings['bio_align'] = ao($config, 'defaults.bio_align');

            $workspace->settings = $settings;

            // Background
            if (ao($config, 'defaults.background.enable')) {
                $bg = ao($config, 'defaults.background.background');
                if (ao($config, 'defaults.background.source') == 'internal') {
                    $bg = gs("assets/image/theme/$request->theme", $bg);
                }

                $background = $workspace->background_settings ?? [];
                $background['image']['source'] = 'url';
                $background['image']['external_url'] = $bg;
                $workspace->background_settings = $background;
                $workspace->background = 'image';
            }
        }

        $workspace->save();

        return back()->with('success', __('Saved Successfully'));
    }

    public function api()
    {
        // Check if api plugin is installed
        if (!\Plugins::has('api')) {
            abort(404);
        }


        return view('mix::settings.sections.api');
    }

    public function resetApi(Request $request)
    {
        $user = User::find($this->user->id);

        // Log activity before change
        logActivity($user->email, __('api_reset'), __('Api key reset. Previous Key') . ' :' . $user->api);

        // ✅ Segurança: Gerar e hashear token antes de salvar
        $plainToken = \Str::random(60);
        $hashedToken = hash('sha256', $plainToken);

        // Salvar token hasheado no banco
        $user->api = $hashedToken;
        $user->save();

        // Armazenar token plain na sessão temporariamente para exibir ao usuário uma única vez
        // (em produção, considerar usar flash session ou outra forma segura)
        session()->flash('api_token_generated', $plainToken);
        session()->flash('api_token_shown', true);

        // Return with success
        return back()->with('success', __('Api key regenerated Successfully'))->with('api_token', $plainToken);
    }

    public function customize()
    {
        return view('mix::settings.sections.customize');
    }

    public function social()
    {
        $workspaceId = session('active_workspace_id');
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        $workspace = $workspaceId ? \App\Models\Workspace::find($workspaceId) : null;

        // Create a temporary user object with workspace social data for ordered_social
        $tempUser = clone $this->user;
        if ($workspace && $workspace->social) {
            $tempUser->social = $workspace->social;
        }

        $user_social = \App\User::ordered_social($tempUser->id);

        return view('mix::settings.sections.social', ['socials' => $user_social]);
    }

    public function profile()
    {

        $qr = null;
        $path = public_path('media/qrcode/' . strtolower($this->user->username) . '.png');
        try {
            if (!file_exists($path)) {
                $qr = \QrCode::size(500)->format('png')->generate(bio_url($this->user->id), $path);
            }
        } catch (\Exception $e) {

        }

        // Fetch user directly from DB to bypass any overlay/caching
        $account = \DB::table('users')->where('id', auth()->id())->first();
        return view('mix::settings.sections.profile', ['qrcode' => $qr, 'qrpath' => $path, 'account' => $account]);
    }

    public function seo()
    {
        return view('mix::settings.sections.seo');
    }

    public function password()
    {

        return view('mix::settings.sections.password');
    }

    public function pixels()
    {
        $workspaceId = session('active_workspace_id');
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        $pixel = Pixel::where('workspace_id', $workspaceId)->get();
        $skeleton = getOtherResourceFile('pixels');


        $skeleton_pixel = function ($pixel, $key = null) use ($skeleton) {
            if (array_key_exists($pixel, $skeleton)) {
                $pixel_temp = $skeleton[$pixel];

                app('config')->set('pixel-temp', $pixel_temp);
                $key = !empty($key) ? '.' . $key : null;
                return app('config')->get('pixel-temp' . $key);
            }
        };

        $status = function ($status) {
            switch ($status) {
                case 0:
                    return __('Hidden');
                    break;

                case 1:
                    return __('Visible');
                    break;
            }
        };

        return view('mix::settings.sections.pixels', ['pixels' => $pixel, 'skeleton' => $skeleton, 'skeleton_pixel' => $skeleton_pixel, 'status' => $status]);
    }

    public function pixelPost($type, Request $request)
    {
        $workspaceId = session('active_workspace_id');
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        if (!$workspaceId) {
            return back()->with('error', __('Workspace not found'));
        }

        $pixel = new Pixel;

        // Check if post pixel type is correct and procee
        if (!in_array($type, ['new', 'edit', 'delete'])) {
            abort(404);
        }

        // Check if it's in plan
        if (!plan('settings.pixel_codes')) {
            // Can change to a custom page later
            abort(404);
        }

        // Switch type of post
        switch ($type) {
            // New pixel
            case 'new':

                // Validate 
                $request->validate([
                    'pixel_name' => 'required',
                    'pixel_type' => 'required',
                    'pixel_id' => 'required'
                ]);

                // Post Pixel
                $pixel->user = $this->user->id;
                $pixel->workspace_id = $workspaceId;
                $pixel->name = $request->pixel_name;
                $pixel->status = $request->pixel_status;
                $pixel->pixel_id = $request->pixel_id;
                $pixel->pixel_type = $request->pixel_type;

                $pixel->save();


                // Return to previous page with success
                return back()->with('success', __('Pixel Saved'));
                break;

            case 'edit':
                // Validate 
                $request->validate([
                    'pixel_name' => 'required',
                    'pixel_id' => 'required'
                ]);

                // Check if pixel exists
                if (!$pixel = $pixel->where('workspace_id', $workspaceId)->where('id', $request->id)->first()) {
                    return back()->with('info', __('Pixel cant be found'));
                }

                //

                // Post Pixel
                $pixel->name = $request->pixel_name;
                $pixel->status = $request->pixel_status;
                $pixel->pixel_id = $request->pixel_id;
                $pixel->pixel_type = $request->pixel_type;

                $pixel->save();


                // Return to previous page with success
                return back()->with('success', __('Pixel Saved'));
                break;

            case 'delete':
                // Check if pixel exists
                if (!$pixel = $pixel->where('workspace_id', $workspaceId)->where('id', $request->id)->first()) {
                    return back()->with('info', __('Pixel cant be found'));
                }
                $delete = Pixel::find($pixel->id);

                // Delete the pixel
                $delete->delete();
                // Return to previous page with success
                return back()->with('success', __('Pixel Deleted'));
                break;

        }
    }

    public function authactivity()
    {
        $activity = Authactivity::where('user', $this->user->id)->orderBy('id', 'DESC')->get()->groupBy(function ($type) {
            return $type->type;
        })->toArray();

        asort($activity);

        $activity = json_decode(json_encode($activity));

        return view('mix::settings.sections.authactivity', ['activity' => $activity]);
    }

    public function seoRemoveGraphImage()
    {

        if (!empty($previous_image = user('seo.opengraph_image'))) {
            if (mediaExists('media/bio/seo', $previous_image)) {
                \UserStorage::remove('media/bio/seo', $previous_image);
            }
        }

        return redirect()->route('user-mix-settings-seo')->with('success', __('Image removed successfully'));
    }

    public function post($type, Request $request)
    {
        $edit = User::find($this->user->id)->fresh();

        // Get active workspace for workspace-specific settings
        $workspaceId = session('active_workspace_id');
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->first();
            $workspaceId = $defaultWorkspace ? $defaultWorkspace->id : null;
        }
        $workspace = $workspaceId ? \App\Models\Workspace::find($workspaceId) : null;

        // Post Seo section (WORKSPACE-SPECIFIC)
        if ($type == 'seo') {
            // Check if it's in plan
            if (!plan('settings.seo')) {
                // Can change to a custom page later
                abort(404);
            }

            if (!$workspace) {
                return back()->with('error', __('Workspace not found'));
            }

            $seo = $workspace->seo ?? [];

            if (!empty($request->seo) && is_array($request->seo)) {
                foreach ($request->seo as $key => $value) {
                    $seo[$key] = $value;
                }
            }

            if (!empty($request->opengraph_image)) {
                $request->validate([
                    'opengraph_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                if (!empty($previous_image = ao($workspace->seo, 'opengraph_image'))) {
                    if (mediaExists('media/bio/seo', $previous_image)) {
                        \UserStorage::remove('media/bio/seo', $previous_image);
                    }
                }

                $imageName = \UserStorage::put('media/bio/seo', $request->opengraph_image, $this->user->id);
                $seo['opengraph_image'] = $imageName;
            }

            $workspace->seo = $seo;
            $workspace->save();

            return back()->with('success', __('Saved Successfully'));
        }

        // Post Profile section

        if ($type == 'profile') {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $this->user->id,
                'username' => 'required|string|unique:users,username,' . $this->user->id,
                'name' => 'required|min:2',
            ]);

            $settings = $edit->settings;

            if ($request->sandy_upload_media_type == 'external' && user('avatar_settings.link') !== $request->sandy_upload_media_link) {
                $settings['avatar_color'] = colorFromImage($request->sandy_upload_media_link);
            }


            $avatar_settings = sandy_upload_modal_upload($request, 'media/bio/avatar', '2048', $edit->id, $edit->avatar_settings);

            if (!empty($request->sandy_upload_media_upload)) {
                $settings['avatar_color'] = colorFromImage(gs('media/bio/avatar', ao($avatar_settings, 'upload')));
                $edit->settings = $settings;
            }

            $edit->avatar_settings = $avatar_settings;

            // Work on username if exists
            $username = slugify($request->username);

            // Loop & Post Settings

            if (!empty($setting = $request->settings)) {
                foreach ($setting as $key => $value) {
                    $settings[$key] = $value;
                }
            }

            $edit->settings = $settings;
            $edit->name = $request->name;
            $edit->email = $request->email;
            $edit->username = $username;
            $edit->bio = $request->bio;

            $edit->save();

            // IMPORTANT: Also update the default workspace to keep data in sync
            // This ensures the workspace overlay shows the correct data
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $edit->id)
                ->where('is_default', 1)
                ->first();

            if ($defaultWorkspace) {
                $defaultWorkspace->name = $request->name;
                $defaultWorkspace->slug = $username;
                // Note: workspaces don't have a 'bio' column, so we only sync name and slug
                $defaultWorkspace->save();
            }

            return back()->with('success', __('Saved Successfully'));
        }

        if ($type == 'password') {
            $request->validate([
                'password' => 'min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*#?&]/|required|confirmed',
            ]);


            $edit->password = Hash::make($request->password);

            $edit->save();

            return back()->with('success', __('Saved Successfully'));
        }

        // Post payment methods

        if ($type == 'payments') {
            // Check if there's current payment keys
            $payments = $edit->payments;

            // Check & loop our payment methods array's

            if (!empty($request->payments)) {
                foreach ($request->payments as $key => $value) {
                    $payments[$key] = $value;
                }
            }


            $edit->payments = $payments;
            $edit->save();
            return back()->with('success', __('Saved Successfully'));
        }

        if ($type == 'customize') {
            if (!$workspace) {
                return back()->with('error', __('Workspace not found'));
            }

            // Button
            $button = [];
            if (!empty($request->button)) {
                foreach ($request->button as $key => $value) {
                    $button[$key] = $value;
                }
            }

            // Color
            $color = [];

            if (!empty($request->color)) {
                foreach ($request->color as $key => $value) {
                    $color[$key] = $value;
                }
            }

            try {
                $color['button_color'] = getContrastColor(ao($request->color, 'button_background'));
            } catch (\Exception $e) {

            }

            // Background

            $background_settings = [];


            // Background Gradient
            if (!empty($request->background_settings)) {
                foreach ($request->background_settings as $key => $value) {
                    $background_settings[$key] = $value;
                }
            }

            // Settings

            $settings = $workspace->settings ?? [];
            // Loop & Post Settings

            if (!empty($setting = $request->settings)) {
                foreach ($setting as $key => $value) {
                    $settings[$key] = $value;
                }
            }

            // Post background image

            if (!empty($request->background_image_input)) {
                $slug = md5(microtime());
                $request->validate([
                    'background_image_input' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if (!empty($image = ao($workspace->background_settings, 'image.image'))) {
                    if (mediaExists('media/bio/background', $image)) {
                        \UserStorage::remove('media/bio/background', $image);
                    }
                }

                $name = \UserStorage::put('media/bio/background', $request->background_image_input, $this->user->id);
                $background_settings['image']['image'] = $name;
            } else {
                $background_settings['image']['image'] = ao($workspace->background_settings, 'image.image');
            }

            if (!empty($request->background_video_input)) {
                $slug = md5(microtime());
                $request->validate([
                    'background_video_input' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20048',
                ]);

                if (!empty($video = ao($workspace->background_settings, 'video.video'))) {
                    if (mediaExists('media/bio/background', $video)) {
                        \UserStorage::remove('media/bio/background', $video);
                    }
                }

                $name = \UserStorage::put('media/bio/background', $request->background_video_input, $this->user->id);
                $background_settings['video']['video'] = $name;
            } else {
                $background_settings['video']['video'] = ao($workspace->background_settings, 'video.video');
            }



            $workspace->buttons = $button;
            $workspace->color = $color;
            $workspace->background_settings = $background_settings;

            // Allow any font string to be saved (Google Fonts support)
            // Previously might have been restricted or filtered
            $workspace->font = $request->font;

            $workspace->background = $request->background;
            $workspace->settings = $settings;

            $workspace->save();


            return back()->with('success', __('Saved Successfully'));
        }

        if ($type == 'social') {
            if (!$workspace) {
                return back()->with('error', __('Workspace not found'));
            }

            // Check if it's in plan
            if (!plan('settings.social')) {
                // Can change to a custom page later
                abort(404);
            }

            $socials = $request->socials;
            $workspace->social = $socials;

            $workspace->save();

            return back()->with('success', __('Saved Successfully'));
        }


        return back()->with('error', __('Undefined Method'));
    }
    public function deleteAccount(Request $request)
    {
        $user = User::find($this->user->id);

        if (!$user) {
            abort(404);
        }

        try {
            // 1. Criar backup completo usando o serviço
            $backupService = new UserBackupService();
            $backup = $backupService->createBackup($user);

            if (!$backup) {
                return back()->with('error', __('Erro ao criar backup da conta. Por favor, tente novamente ou entre em contato com o suporte.'));
            }

            // 2. Deletar todos os workspaces (usando soft delete também se necessário)
            foreach ($user->workspaces as $workspace) {
                \Modules\Mix\Http\Controllers\WorkspaceController::processDeletion($workspace);
            }

            // 3. Soft delete do usuário (não deleta permanentemente, apenas marca como deletado)
            // Logout antes de deletar para evitar problemas
            Auth::logout();

            $user->delete(); // Soft delete

            return redirect()->route('user-login')->with('success', __('Conta deletada com sucesso. Seus dados foram salvos e podem ser restaurados em até 6 meses através do suporte.'));

        } catch (\Exception $e) {
            \Log::error("Erro ao deletar conta do usuário ID: {$user->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', __('Erro ao processar a exclusão da conta. Por favor, entre em contato com o suporte.'));
        }
    }
}
