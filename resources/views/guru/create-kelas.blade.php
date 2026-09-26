<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembuatan Kelas</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4 font-sans">

    <!-- Container Utama -->
    <div class="bg-slate-50 w-full max-w-6xl rounded-2xl shadow-2xl flex overflow-hidden min-h-[650px] border border-gray-200">
        
        <!-- SIDEBAR UNGU -->
        <div class="w-64 bg-indigo-600 text-white flex flex-col justify-between p-6">
            <div>
                <!-- Logo / Header Sidebar -->
                <div class="flex items-center space-x-3 mb-10 px-2">
                    <div class="bg-white text-indigo-600 p-2 rounded-lg font-bold">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="font-bold text-lg tracking-wide">E-Classroom</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 bg-indigo-500/50 text-white px-4 py-3 rounded-xl font-medium shadow-sm transition">
                        <i class="fa-solid fa-shapes text-sm"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-indigo-100 hover:bg-indigo-500/30 px-4 py-3 rounded-xl font-medium transition">
                        <i class="fa-solid fa-chalkboard-user text-sm"></i>
                        <span>Data Kelas</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-indigo-100 hover:bg-indigo-500/30 px-4 py-3 rounded-xl font-medium transition">
                        <i class="fa-solid fa-list-check text-sm"></i>
                        <span>Laporan</span>
                    </a>
                </nav>
            </div>

            <!-- Tombol Kembali / Back Bottom -->
            <div>
                <button class="w-10 h-10 bg-white text-indigo-600 rounded-full flex items-center justify-center shadow-md hover:bg-indigo-50 transition">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
            </div>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 p-8 overflow-y-auto">
            
            <!-- Judul Halaman -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 tracking-wide uppercase">FORM PEMBUATAN KELAS</h1>
                <p class="text-xs text-gray-400 font-semibold tracking-wider mt-1">SISTEM MANAJEMEN KELAS</p>
            </div>

            <!-- Pesan Sukses / Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl text-sm flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Input Kelas -->
            <form action="{{ url('/kelas/create') }}" method="POST" class="mb-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    
                    <!-- Input Nama Kelas (Wajib Diisi) -->
                    <div>
                        <label for="nama_kelas" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Kelas</label>
                        <input type="text" 
                               name="nama_kelas" 
                               id="nama_kelas" 
                               placeholder="Masukkan Nama Kelas (misal: XII RPL 1)" 
                               value="{{ old('nama_kelas') }}"
                               class="w-full px-4 py-3 text-sm rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition text-gray-700 @error('nama_kelas') border-red-500 @enderror" 
                               required>
                        @error('nama_kelas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Nama Guru / Pembuat Kelas (Otomatik / Disabled) -->
                    <div>
                        <label for="pembuat" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pembuat Kelas (Guru)</label>
                        <div class="relative">
                            <input type="text" 
                                   id="pembuat" 
                                   value="{{ Auth::user()->name ?? 'Nama Guru' }}" 
                                   class="w-full px-4 py-3 text-sm rounded-lg bg-gray-100 border border-gray-200 text-gray-500 font-medium cursor-not-allowed" 
                                   readonly>
                            <i class="fa-solid fa-lock absolute right-3 top-3.5 text-gray-400 text-xs"></i>
                        </div>
                        <span class="text-[11px] text-gray-400 mt-1 block">* Terisi otomatis dari akun yang sedang login</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="md:col-span-2 flex justify-end space-x-3 pt-2">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-lg shadow-sm transition flex items-center space-x-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan</span>
                        </button>
                        <button type="reset" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-lg shadow-sm transition flex items-center space-x-2">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset</span>
                        </button>
                    </div>

                </div>
            </form>

            <!-- TABEL DATA KELAS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-700">Tabel Data Kelas</h2>
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold uppercase bg-gray-50">
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">Nama Kelas</th>
                                <th class="py-3 px-4">Guru Pembuat</th>
                                <th class="py-3 px-4">Tanggal Dibuat</th>
                                <th class="py-3 px-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            <!-- Contoh perulangan Blade untuk data kelas -->
                            @forelse($kelases ?? [] as $index => $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3 px-4 text-center font-medium">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->nama_kelas }}</td>
                                    <td class="py-3 px-4">{{ $item->user->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button class="bg-emerald-500 text-white w-6 h-6 rounded flex items-center justify-center hover:bg-emerald-600 transition">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                            </button>
                                            <button class="bg-rose-500 text-white w-6 h-6 rounded flex items-center justify-center hover:bg-rose-600 transition">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-400 italic">Belum ada data kelas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer / Paginasi Tabel -->
                <div class="flex justify-between items-center mt-4 text-xs text-gray-400">
                    <span>Menampilkan data kelas</span>
                    <div class="flex space-x-1">
                        <button class="w-6 h-6 rounded bg-gray-100 text-gray-500 flex items-center justify-center text-[10px]"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="w-6 h-6 rounded bg-indigo-600 text-white font-bold flex items-center justify-center text-[10px]">1</button>
                        <button class="w-6 h-6 rounded bg-gray-100 text-gray-500 flex items-center justify-center text-[10px]"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>