@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Anggota</h2>
                <p class="text-gray-500 mt-1 font-medium">Perbarui data informasi untuk akun: <span class="font-bold text-slate-800">{{ $member->name }}</span></p>
            </div>
            <a href="{{ route('admin.superadmin.members.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Error Validasi Umum --}}
        @if ($errors->any())
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Terdapat Kesalahan:
                </div>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-7 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card Utama --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.superadmin.members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ========================================== --}}
                {{-- BAGIAN 1: INFORMASI UMUM --}}
                {{-- ========================================== --}}
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>👤</span> Informasi Umum
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $member->name) }}" required
                                   class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('name') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" required
                                   class="w-full px-4 py-3 rounded-xl border @error('email') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('email') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Nomor Telepon --}}
                        <div>
                            <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon (Opsional)</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $member->phone_number) }}" placeholder="Contoh: 0812..."
                                   class="w-full px-4 py-3 rounded-xl border @error('phone_number') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('phone_number') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Role Akun <span class="text-rose-500">*</span></label>
                            <select id="role" name="role" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white cursor-pointer font-semibold text-gray-700">
                                <option value="siswa" @selected(old('role', $member->role) == 'siswa')>Siswa</option>
                                <option value="guru" @selected(old('role', $member->role) == 'guru')>Guru</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="h-px bg-gray-100 my-8"></div>

                {{-- ========================================== --}}
                {{-- BAGIAN 2: DETAIL BERDASARKAN ROLE --}}
                {{-- ========================================== --}}
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>🎓</span> Detail Akademik
                    </h3>

                    {{-- Form Khusus SISWA --}}
                    <div id="student-fields" class="transition-all duration-300 {{ old('role', $member->role) == 'siswa' ? '' : 'hidden' }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- NIS --}}
                            <div>
                                <label for="nis" class="block text-sm font-bold text-gray-700 mb-2">NIS <span class="text-rose-500">*</span></label>
                                <input type="text" id="nis" name="nis" value="{{ old('nis', $member->nis) }}"
                                       class="w-full px-4 py-3 rounded-xl border @error('nis') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white font-mono">
                                @error('nis') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Kelas --}}
                            <div>
                                <label for="class" class="block text-sm font-bold text-gray-700 mb-2">Kelas <span class="text-rose-500">*</span></label>
                                <select id="class" name="class" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white cursor-pointer">
                                    <option value="">Pilih Tingkat Kelas</option>
                                    <option value="X" @selected(old('class', $member->class) == 'X')>X</option>
                                    <option value="XI" @selected(old('class', $member->class) == 'XI')>XI</option>
                                    <option value="XII" @selected(old('class', $member->class) == 'XII')>XII</option>
                                    @if($member->class == 'Lulus')
                                        <option value="Lulus" @selected(true) disabled>Alumni / Lulus</option>
                                    @endif
                                </select>
                                @error('class') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div>
                                <label for="major" class="block text-sm font-bold text-gray-700 mb-2">Jurusan <span class="text-rose-500">*</span></label>
                                <select id="major" name="major" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white cursor-pointer">
                                    <option value="">Pilih Jurusan</option>
                                    @if(isset($majors))
                                        @foreach($majors as $major)
                                            <option value="{{ $major->name }}" @selected(old('major', $member->major) == $major->name)>
                                                {{ $major->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('major') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Form Khusus GURU --}}
                    <div id="teacher-fields" class="transition-all duration-300 {{ old('role', $member->role) == 'guru' ? '' : 'hidden' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran <span class="text-rose-500">*</span></label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject', $member->subject) }}" placeholder="Contoh: Matematika"
                                       class="w-full px-4 py-3 rounded-xl border @error('subject') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                @error('subject') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-px bg-gray-100 my-8"></div>

                {{-- ========================================== --}}
                {{-- BAGIAN 3: PENGATURAN AKUN --}}
                {{-- ========================================== --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>⚙️</span> Pengaturan Akun
                    </h3>

                    {{-- Status Akun --}}
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2">
                        <div>
                            <label for="account_status" class="block text-sm font-bold text-gray-700 mb-2">Status Akun <span class="text-rose-500">*</span></label>
                            <select id="account_status" name="account_status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-gray-50 focus:bg-white cursor-pointer font-bold text-gray-700">
                                <option value="pending" @selected(old('account_status', $member->account_status) == 'pending')>Pending (Menunggu Persetujuan)</option>
                                <option value="active" @selected(old('account_status', $member->account_status) == 'active')>Active (Aktif)</option>
                                <option value="rejected" @selected(old('account_status', $member->account_status) == 'rejected')>Rejected (Ditolak)</option>
                                <option value="suspended" @selected(old('account_status', $member->account_status) == 'suspended')>Suspended (Ditangguhkan)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Ubah Password --}}
                    <div class="bg-slate-50 rounded-xl border border-slate-100 p-6">
                        <h4 class="font-bold text-gray-900 mb-1">Ubah Password <span class="text-sm font-medium text-gray-500">(Opsional)</span></h4>
                        <p class="text-xs text-gray-500 mb-5">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password akun ini.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                <input type="password" id="password" name="password" placeholder="Isi hanya jika ingin ganti password"
                                       class="w-full px-4 py-3 rounded-xl border @error('password') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-white">
                                @error('password') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-slate-50 focus:ring-4 outline-none transition bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md">
                        Update Anggota
                    </button>
                    <a href="{{ route('admin.superadmin.members.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT DINAMIS --}}
    <script>
        const roleSelect = document.getElementById('role');
        const studentFields = document.getElementById('student-fields');
        const teacherFields = document.getElementById('teacher-fields');

        // Input elemen
        const nisInput = document.getElementById('nis');
        const classInput = document.getElementById('class');
        const majorInput = document.getElementById('major');
        const subjectInput = document.getElementById('subject');

        function toggleRoleFields() {
            const selectedRole = roleSelect.value;

            if (selectedRole === 'siswa') {
                // Tampilkan Siswa, Sembunyikan Guru
                studentFields.classList.remove('hidden');
                teacherFields.classList.add('hidden');

                // Wajibkan Siswa
                nisInput.required = true;
                classInput.required = true;
                majorInput.required = true;

                // Hapus Wajib Guru
                subjectInput.required = false;

            } else if (selectedRole === 'guru') {
                // Tampilkan Guru, Sembunyikan Siswa
                teacherFields.classList.remove('hidden');
                studentFields.classList.add('hidden');

                // Hapus Wajib Siswa
                nisInput.required = false;
                classInput.required = false;
                majorInput.required = false;

                // Wajibkan Guru
                subjectInput.required = true;
            }
        }

        // Jalankan saat dropdown diubah
        roleSelect.addEventListener('change', toggleRoleFields);

        // Jalankan saat pertama kali dimuat
        document.addEventListener('DOMContentLoaded', toggleRoleFields);
    </script>
@endsection
