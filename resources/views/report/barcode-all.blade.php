<!DOCTYPE html>
<html lang="en">
<style>
    @page{ margin: 10px; }
</style>
<body>
    <table border="0" cellpadding="1" cellspacing="0" style="padding:5px;line-height:1;">
        @foreach($barcode as $result)

            <tbody>
                <tr style="padding: 10px;">
                    <td rowspan="4" colspan="4">{!! DNS2D::getBarcodeHTML($result->barcode, 'QRCODE', 5, 5) !!}</td>
                    <td rowspan="4" colspan="4"> </td>
                    <td colspan="2" style="text-align: center;">{!! DNS1D::getBarcodeHTML($result->barcode, "C39", 1, 35) !!}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; text-transform: uppercase;font-weight:400">{{ $result->barcode }}</td>
                </tr>
                
                <tr>
                    @foreach($result->toolcategory as $category)
                    <td style="font-size:11pt;">{{ $category->description }}</td>
                    @endforeach
                    @foreach($result->toolname as $name)
                    <td style="font-size:11pt;">{{ $name->description }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td style="font-size:11pt;">{{ $result->brand }}</td>
                    <td style="font-size:11pt;">{{ $result->property }}</td>
                </tr>
            </tbody>
        @endforeach
    </table>                        
</body>

</html>