<x-mail::message>
<x-mail::header :url="config('app.url')">
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Coat_of_arms_of_Pekalongan_Regency.svg/960px-Coat_of_arms_of_Pekalongan_Regency.svg.png" alt="Logo Kabupaten Pekalongan" style="height: 60px; display: inline-block;">
</x-mail::header>

# Ada Pengajuan Surat Baru!

**Halo Admin Desa,**

Pengajuan surat baru telah masuk melalui sistem. Berikut detailnya:

<x-mail::panel>
**Detail Pemohon**<br>
**Nama:** {{ $data['nama'] }}<br>
**No. HP:** {{ $data['no_hp'] }}<br>
**Alamat:** {{ $data['alamat'] }}
</x-mail::panel>

<x-mail::panel>
**Detail Pengajuan**<br>
**Nomor Pengajuan:** {{ $nomor }}<br>
**Jenis Surat:** {{ $data['jenis_surat'] }}<br>
**Keperluan:** {{ $data['keperluan'] }}
</x-mail::panel>

<x-mail::button :url="url('/admin/dashboard')" color="success">
Lihat di Dashboard
</x-mail::button>

Silakan login ke dashboard admin untuk memproses pengajuan ini.

<x-mail::footer>
&copy; {{ date('Y') }} {{ config('app.name') }}. Sistem Administrasi Desa - Kabupaten Pekalongan
</x-mail::footer>
</x-mail::message>
