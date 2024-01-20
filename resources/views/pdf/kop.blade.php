<table class="table font-08">
    <tr>
        <td style="width: 3cm;">
            <img src="data:image/png;base64, {{ base64_encode(file_get_contents( $feature_image_path )) }}" style="width: 100%;" />
        </td>
        <td style="padding-top: 10px;">
            <h1 class="text-center margin-5">{{ $pengaturan['nama_aplikasi'] }}</h1>

            <p class="text-center margin-5">Alamat : {{ strip_tags($pengaturan['alamat']) }}
            </p>
        </td>
        <td style="width: 3cm;">
            <img src="data:image/png;base64, {{ base64_encode(file_get_contents( $logo_image_path )) }}" style="width: 100%;" />
        </td>
    </tr>
</table>
<hr class="hr-double"/>
