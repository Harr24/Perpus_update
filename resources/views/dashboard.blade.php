@if(auth()->user()->role == 'superadmin')
    @include('admin.superadmin.dashboard')

@elseif(auth()->user()->role == 'petugas')
    @include('admin.petugas.dashboard')

@elseif(auth()->user()->role == 'guru')
    @include('guru.dashboard')

@elseif(auth()->user()->role == 'siswa')
    @include('siswa.dashboard')

@endif
