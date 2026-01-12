<?php

namespace Sandy\Blocks\booking\Livewire;

use Livewire\Component;
use Sandy\Blocks\booking\Models\BookingService;

class Services extends Component
{

    public $user_id;
    public $user;
    public $workspace_id;  // ✅ Adicionar workspace_id

    public $services;
    protected $rules = [

        'services.*.name' => 'required',
        'services.*.duration' => 'required|numeric',
        'services.*.price' => 'required|numeric',

    ];

    public function mount(){
        $this->user = \App\User::find($this->user_id);

        // ✅ Usar workspace da sessão (selecionado pelo usuário)
        $sessionWorkspaceId = session('active_workspace_id');
        
        if ($sessionWorkspaceId) {
            $workspace = \App\Models\Workspace::where('id', $sessionWorkspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            $this->workspace_id = $workspace ? $workspace->id : null;
        }
        
        // ✅ Fallback: se não houver workspace na sessão, usar default
        if (!$this->workspace_id) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            $this->workspace_id = $defaultWorkspace ? $defaultWorkspace->id : null;
        }

        $this->refresh();
    }

    public function create(){
        $settings = [
            'duration' => '30'
        ];
        $service = new BookingService;
        $service->user = $this->user_id;
        $service->workspace_id = $this->workspace_id;  // ✅ Adicionar workspace_id
        $service->name = __('My New Booking Service');
        $service->price = 200;
        $service->duration = 60;
        $service->save();
        
        $this->refresh();
    }

    public function sort($list){
        foreach ($list as $key => $value) {
            $value['value'] = (int) $value['value'];
            $value['order'] = (int) $value['order'];
            $update = BookingService::where('id', $value['value'])
                ->where('user', $this->user_id)
                ->where('workspace_id', $this->workspace_id)
                ->first();
            
            if ($update) {
                $update->position = $value['order'];
                $update->save();
            }
        }
        
        $this->refresh();
    }

    public function edit($id, $index){
        // ✅ Buscar o serviço específico e validar workspace_id primeiro
        $service = BookingService::where('id', $id)
            ->where('user', $this->user_id)
            ->where('workspace_id', $this->workspace_id)
            ->first();

        if (!$service) {
            $this->addError('service', __('Service not found.'));
            $this->refresh();
            return;
        }

        // ✅ Validar os dados do formulário
        try {
            $validated = $this->validate([
                "services.{$index}.name" => 'required|string|max:255',
                "services.{$index}.duration" => 'required|numeric|min:1',
                "services.{$index}.price" => 'required|numeric|min:0',
            ]);

            // ✅ Atualizar o serviço com os dados validados
            if (isset($validated['services'][$index])) {
                $service->name = $validated['services'][$index]['name'];
                $service->duration = (int) $validated['services'][$index]['duration'];
                $service->price = (float) $validated['services'][$index]['price'];
                $service->save();
            } else {
                // Fallback: pegar diretamente do request se validação não retornou dados
                $request = request();
                $service->name = $request->input("services.{$index}.name", $service->name);
                $service->duration = (int) $request->input("services.{$index}.duration", $service->duration);
                $service->price = (float) $request->input("services.{$index}.price", $service->price);
                $service->save();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Se a validação falhar, os erros já serão exibidos automaticamente
            return;
        }

        $this->refresh();
        session()->flash('message', __('Service updated successfully.'));
    }

    public function delete($id){
        if (!$delete = BookingService::where('id', $id)
            ->where('user', $this->user_id)
            ->where('workspace_id', $this->workspace_id)
            ->first()) {
            return false;
        }
        $delete->delete();
        $this->refresh();
    }
    

    public function refresh(){
        $services = BookingService::where('user', $this->user_id)
            ->where('workspace_id', $this->workspace_id) // ✅ Filtro Estrito: Evita vazamento entre workspaces
            ->orderBy('position', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();
        
        $this->services = $services;
    }

    public function render()
    {

        return view('Blocks-booking::mix.livewire.services');
    }
}
