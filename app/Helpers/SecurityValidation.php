<?php

if (!function_exists('validateFileMagicBytes')) {
    /**
     * ✅ Segurança: Valida arquivo verificando magic bytes (conteúdo real)
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $allowedMimeTypes
     * @return bool
     * @throws \Exception
     */
    function validateFileMagicBytes($file, array $allowedMimeTypes = [])
    {
        if (!$file || !$file->isValid()) {
            throw new \Exception('Invalid file upload');
        }

        // Verificar magic bytes (conteúdo real do arquivo)
        $realPath = $file->getRealPath();
        
        if (!file_exists($realPath)) {
            throw new \Exception('File not found');
        }

        $mimeType = mime_content_type($realPath);
        
        if ($mimeType === false) {
            throw new \Exception('Unable to detect file type');
        }

        // Se tipos específicos foram fornecidos, validar contra eles
        if (!empty($allowedMimeTypes)) {
            if (!in_array($mimeType, $allowedMimeTypes)) {
                throw new \Exception("Invalid file type. Expected: " . implode(', ', $allowedMimeTypes) . ", got: {$mimeType}");
            }
        }

        return true;
    }
}

if (!function_exists('sanitizeFileName')) {
    /**
     * ✅ Segurança: Sanitiza nome de arquivo removendo caracteres perigosos
     * 
     * @param string $filename
     * @return string
     */
    function sanitizeFileName($filename)
    {
        // Remover caminhos relativos e caracteres perigosos
        $filename = basename($filename);
        
        // Remover caracteres especiais, manter apenas alfanuméricos, ponto, hífen e underscore
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
        
        // Limitar tamanho
        $filename = substr($filename, 0, 255);
        
        // Prevenir nomes vazios
        if (empty($filename)) {
            $filename = 'file_' . time();
        }

        return $filename;
    }
}

if (!function_exists('validateImageFile')) {
    /**
     * ✅ Segurança: Validação completa de arquivo de imagem
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $maxSizeBytes
     * @return bool
     * @throws \Exception
     */
    function validateImageFile($file, $maxSizeBytes = 2097152) // 2MB padrão
    {
        if (!$file || !$file->isValid()) {
            throw new \Exception('Invalid file upload');
        }

        // Tipos MIME permitidos para imagens
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml'
        ];

        // Validar magic bytes
        validateFileMagicBytes($file, $allowedMimes);

        // Validar extensão
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Invalid file extension');
        }

        // Validar tamanho
        if ($file->getSize() > $maxSizeBytes) {
            $maxSizeMB = round($maxSizeBytes / 1048576, 2);
            throw new \Exception("File size exceeds maximum allowed size of {$maxSizeMB}MB");
        }

        return true;
    }
}

