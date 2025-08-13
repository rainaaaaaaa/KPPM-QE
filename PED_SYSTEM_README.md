# Sistem PED - Smart PED

## Overview
Sistem ini telah diperbarui untuk menambahkan user baru bernama "PED" dengan fitur-fitur khusus untuk review dan approval proyek mitra.

## User Roles

### 1. Mitra (Partner)
- **Fungsi**: Mengirim proyek untuk review
- **Fitur**:
  - Dashboard mitra
  - Tambah proyek baru
  - Lihat daftar proyek
  - Upload foto proyek
  - Status proyek: Planning, Berjalan, Selesai

### 2. PED
- **Fungsi**: Review dan approval proyek mitra
- **Fitur**:
  - Dashboard PED dengan statistik
  - Review proyek mitra
  - Approve/Reject proyek
  - Pencarian dan filter dokumen
  - Notifikasi proyek baru

## Login Credentials

### User PED
- **Email**: ped@smartped.com
- **Password**: password
- **Role**: ped

### User Mitra (existing)
- **Email**: rainarii11111@gmail.com
- **Password**: (sesuai yang sudah ada)
- **Role**: partner

## Fitur PED

### 1. Dashboard PED
- Statistik total proyek
- Jumlah proyek menunggu review
- Jumlah proyek disetujui/ditolak
- Daftar proyek menunggu review

### 2. Dokumen Proyek (Index)
- Pencarian berdasarkan:
  - Nomor kontrak
  - Lokasi
  - Jenis proyek (all)
- Filter berdasarkan:
  - Status planning (planning, berjalan, selesai)
  - Status approval (pending, approved, rejected)
- Pagination untuk daftar proyek

### 3. Review Proyek (Show)
- Detail lengkap proyek mitra
- Foto-foto proyek
- Keterangan dari mitra
- Panel approve/reject dengan:
  - Tombol approve (opsional catatan)
  - Tombol reject (wajib alasan)
  - Status review yang sudah dilakukan

### 4. Notifikasi
- Daftar proyek terbaru yang perlu direview
- Link cepat ke review proyek

## Workflow

### Alur Kerja Mitra:
1. Mitra login ke sistem
2. Buat proyek baru dengan status "Planning"
3. Upload foto dan keterangan
4. Kirim proyek (status tetap "Planning")
5. Menunggu review dari PED

### Alur Kerja PED:
1. PED login ke sistem
2. Lihat dashboard dengan statistik
3. Cek notifikasi proyek baru
4. Review proyek di halaman detail
5. Approve atau reject proyek:
   - **Approve**: Status berubah menjadi "Berjalan"
   - **Reject**: Status tetap "Planning" dengan alasan

## Database Changes

### Tabel `users`
- Kolom `role` enum: ['user', 'partner', 'ped']

### Tabel `mtra_projects`
- Kolom `ped_approved` (boolean, nullable)
- Kolom `ped_reviewed_at` (timestamp, nullable)
- Kolom `ped_notes` (text, nullable)

## Routes

### PED Routes
- `GET /ped/dashboard` - Dashboard PED
- `GET /ped` - Daftar dokumen proyek
- `GET /ped/notifications` - Notifikasi
- `GET /ped/{project}` - Detail proyek
- `POST /ped/{project}/approve` - Approve proyek
- `POST /ped/{project}/reject` - Reject proyek

### Mitra Routes (existing)
- `GET /mtra/dashboard` - Dashboard mitra
- `GET /mtra` - Daftar proyek mitra
- `GET /mtra/create` - Form tambah proyek
- `POST /mtra` - Simpan proyek baru
- `GET /mtra/{project}` - Detail proyek
- `DELETE /mtra/{project}` - Hapus proyek

## Navigation

Sistem akan menampilkan menu yang berbeda berdasarkan role user:
- **PED**: Dashboard, Dokumen Proyek, Notifikasi
- **Mitra**: Dashboard, Project Mitra, Tambah Project

## Status Proyek

### Status Planning:
- **Planning**: Proyek baru, menunggu review PED
- **Berjalan**: Proyek disetujui PED, sedang berjalan
- **Selesai**: Proyek selesai

### Status Approval PED:
- **Pending**: Belum direview
- **Approved**: Disetujui
- **Rejected**: Ditolak

## Testing

Untuk test sistem:
1. Login sebagai mitra: rainarii11111@gmail.com
2. Buat proyek baru
3. Login sebagai PED: ped@smartped.com
4. Review dan approve/reject proyek
5. Cek perubahan status proyek
