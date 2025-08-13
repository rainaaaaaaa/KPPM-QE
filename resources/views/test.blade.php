<!DOCTYPE html>
<html>
<head>
    <title>Test Project</title>
</head>
<body>
    <h1>Test Project Data</h1>
    
    @if($project)
        <p><strong>ID:</strong> {{ $project->id }}</p>
        <p><strong>Nomor Kontrak:</strong> {{ $project->nomor_kontrak }}</p>
        <p><strong>Lokasi:</strong> {{ $project->lokasi }}</p>
        <p><strong>Jenis:</strong> {{ $project->jenis }}</p>
        <p><strong>Keterangan:</strong> {{ $project->keterangan }}</p>
        <p><strong>User:</strong> {{ $project->user ? $project->user->name : 'No user' }}</p>
        <p><strong>Created:</strong> {{ $project->created_at }}</p>
    @else
        <p>Project tidak ditemukan</p>
    @endif
</body>
</html> 