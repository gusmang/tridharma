<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AcaraController;
use App\Http\Controllers\Dashboard\DokumentasiAcaraController;
use App\Http\Controllers\Dashboard\PengaturanController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\JadwalAcaraController;
use App\Http\Controllers\Dashboard\HalamanController;
use App\Http\Controllers\Dashboard\LaporanAcaraController;
use App\Http\Controllers\Dashboard\LaporanTransferController;
use App\Http\Controllers\Dashboard\MetaController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PesertaController;
use App\Http\Controllers\Dashboard\PembayaranController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\OrderControllerOld;

route::middleware('auth')->group(function () {
    route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('acara/cari-acara', [AcaraController::class, 'cariAcara'])->name('acara.cariAcara');
        Route::post('get_acara', [AcaraController::class, 'getAcara'])->name('acara.getAcara');
        Route::resource('acara', AcaraController::class);

        Route::post('change-agenda', [DokumentasiAcaraController::class, 'change_acara'])->name('dokumentasi-acara.change_acara');


        Route::get('dokumentasi-acara', [DokumentasiAcaraController::class, 'index'])->name('dokumentasi-acara.index');
        Route::get('dokumentasi-acara/datatable', [DokumentasiAcaraController::class, 'datatable'])->name('dokumentasi-acara.datatable');
        Route::get('dokumentasi-acara/{peserta_id}', [DokumentasiAcaraController::class, 'show'])->name('dokumentasi-acara.show');
        Route::get('list-order/datatable', [DokumentasiAcaraController::class, 'datatable'])->name('dokumentasi-acara.datatable');

        Route::resource('media', MediaController::class);
        Route::get('jadwal-acara/acara-jadwal-kosong', [JadwalAcaraController::class, 'jadwalKosong'])->name('jadwal-acara.jadwal-kosong');
        Route::resource('jadwal-acara', JadwalAcaraController::class);

        Route::resource('halaman', HalamanController::class);
        Route::get('halaman/hapus-feature-image/{id}', [HalamanController::class, 'deleteFI'])->name('halaman.hapus-feature-image');

        Route::get('peserta/datatable', [PesertaController::class, 'datatable'])->name('peserta.datatable');
        Route::resource('peserta', PesertaController::class);

        Route::get('report-acara', [LaporanAcaraController::class, 'index'])->name('laporan-acara.index');
        Route::get('report-acara/datatable', [LaporanAcaraController::class, 'datatable'])->name('laporan-acara.datatable');
        Route::get('report-acara/{acara_id}/daftar-peserta', [LaporanAcaraController::class, 'exportPeserta'])->name('laporan-acara.export-peserta');

        Route::get('transfer-cash', [LaporanTransferController::class, 'index'])->name('transfer-cash.index');
        Route::get('report-cash', [LaporanTransferController::class, 'datatable'])->name('report-cash.datatable');

        Route::prefix('meta')->group(function () {
            Route::get('set-order', [MetaController::class, 'setOrder'])->name('meta.set-order');
            Route::get('delete', [MetaController::class, 'delete'])->name('meta.delete');
        });

        Route::get('test-cash', [OrderController::class, 'test_cash'])->name('list-order.testcash');

        Route::get('list-order', [OrderController::class, 'index'])->name('list-order.index');
        Route::get('list-terima', [OrderController::class, 'terima'])->name('list-terima.index');
        Route::post('edit-order/pembayaran', [OrderController::class, 'pembayaran'])->name('edit-order.pembayaran');
        Route::post('terima-bayar', [OrderController::class, 'terima_pembayaran'])->name('terima-bayar');
        Route::get('list-order/bayar/{index}', [OrderController::class, 'bayar'])->name('list-order.bayar');
        Route::get('list-order/dataterima/', [OrderController::class, 'datatablePaymentCash'])->name('list-order.dataterima');
        Route::get('cancel-order/{index}', [OrderController::class, 'cancelOrder'])->name('cancel-order.index');
        Route::get('list-order/datatable', [OrderController::class, 'datatable'])->name('list-order.datatable');
        Route::get('list-order/datatableUpload', [OrderController::class, 'datatableUpload'])->name('list-order.datatableUpload');
        Route::get('list-order/{peserta_id}', [OrderController::class, 'show'])->name('list-order.show');
        Route::post('edit-order/update', [OrderController::class, 'editOrder'])->name('edit-order.update');
        Route::post('list-order/{peserta_id}/upload-bukti-bayar', [OrderController::class, 'uploadBuktiBayar'])->name('list-order.upload-bukti-bayar');
        Route::get('list-order/{peserta_id}/{pembayaran_id}/acc', [OrderController::class, 'acc'])->name('list-order.acc');
        Route::get('list-order/{peserta_id}/{pembayaran_id}/reject', [OrderController::class, 'reject'])->name('list-order.reject');
        Route::get('list-order/{peserta_id}/{pembayaran_id}/tolak', [OrderController::class, 'tolak'])->name('list-order.tolak');
        Route::delete('list-order/{peserta_id}/{pembayaran_id}/delete', [OrderController::class, 'hapusPembayaran'])->name('list-order.hapus-pembayaran');

        Route::get('old-list-order', [OrderControllerOld::class, 'index'])->name('old-list-order.index');
        Route::post('old-edit-order/pembayaran', [OrderControllerOld::class, 'pembayaran'])->name('old-edit-order.pembayaran');
        Route::get('old-list-order/bayar/{index}', [OrderControllerOld::class, 'bayar'])->name('old-list-order.bayar');
        Route::get('old-cancel-order/{index}', [OrderControllerOld::class, 'cancelOrder'])->name('old-cancel-order.index');
        Route::get('old-list-order/datatable', [OrderControllerOld::class, 'datatable'])->name('old-list-order.datatable');
        Route::get('old-list-order/datatableUpload', [OrderControllerOld::class, 'datatableUpload'])->name('old-list-order.datatableUpload');
        Route::get('old-list-order/{peserta_id}', [OrderControllerOld::class, 'show'])->name('old-list-order.show');
        Route::post('old-edit-order/update', [OrderControllerOld::class, 'editOrder'])->name('old-edit-order.update');
        Route::post('old-list-order/{peserta_id}/upload-bukti-bayar', [OrderControllerOld::class, 'uploadBuktiBayar'])->name('old-list-order.upload-bukti-bayar');
        Route::get('old-list-order/{peserta_id}/{pembayaran_id}/acc', [OrderControllerOld::class, 'acc'])->name('old-list-order.acc');
        Route::get('old-list-order/{peserta_id}/{pembayaran_id}/reject', [OrderControllerOld::class, 'reject'])->name('old-list-order.reject');
        Route::get('old-list-order/{peserta_id}/{pembayaran_id}/tolak', [OrderControllerOld::class, 'tolak'])->name('old-list-order.tolak');
        Route::delete('old-list-order/{peserta_id}/{pembayaran_id}/delete', [OrderControllerOld::class, 'hapusPembayaran'])->name('old-list-order.hapus-pembayaran');

        Route::resource('pembayaran', PembayaranController::class);
        route::post('pembayaran/bukti-bayar', [PembayaranController::class, 'uploadBuktiBayar'])->name('pembayaran.store.buktibayar');

        Route::resource('user', UserController::class);

        Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('pengaturan', [PengaturanController::class, 'store'])->name('pengaturan.store');
        Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });
});
