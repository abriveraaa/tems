<!DOCTYPE html>
<html lang="en">

<body>
    <table width="100%"  cellspacing="1" cellpadding="0"; style="border-collapse: collapse; line-height:1;">
        <tr>
            <td rowspan="5" style="width: 10%;"><img src="http://localhost/inventory/public/client/img/pup_logo.png"/></td>
            <td rowspan="5" style="width: 1%;"></td>
            <td style="font-family: Calibri; font-size: 11pt">Republic of the Philippines</td>
        </tr>
        <tr>
            <td style="font-size: 11pt;font-family: Californian FB;"><span style="font-size: 14pt;">P</span>OLYTECHNIC <span style="font-size: 14pt;">U</span>NIVERSITY OF THE <span style="font-size: 14pt;">P</span>HILIPPINES</td>
        </tr>
        <tr>
            <td style="font-size: 11pt;font-family: Californian FB;"><span style="font-size: 14pt;">O</span>FFICE OF THE <span style="font-size: 14pt;">V</span>ICE <span style="font-size: 14pt;">P</span>RESIDENT FOR <span style="font-size: 14pt;">A</span>CADEMIC <span style="font-size: 14pt;">A</span>FFAIRS</td>
        </tr>
        <tr>
            <td style="font-size: 15pt;font-family: Californian FB;font-weight:400">INSTITUTE OF TECHNOLOGY</td>
        </tr>
        <tr>
            <td style="font-size: 11pt;font-family: Californian FB;">LABORATORY OFFICE</td>
        </tr>
    </table>
    <hr style="border: 1pt solid black;">
    <div style="margin-top:2rem; text-align: center; text-transform: uppercase;font-family: Calibri;">
        <h3>LIST OF REPORTED ITEM</h3>
    </div>
    
    <div>
        <table border="1" cellspacing="0" style="width:100%;">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>Tool Name</th>
                    <th>Brand</th>
                    <th>Property</th>
                    <th>Room</th>
                    <th>Date Added</th>
                </tr>
            </thead>
        @foreach($reporteditem as $reported)
            <tbody>
                <tr style="font-size:11pt;">
                    <td style="text-align:left; padding: 2px 5px;">{{ $reported->barcode }}</td>
                    @foreach($reported->toolcategory as $category)
                    <td style="text-align:left; padding: 2px 5px;">{{ $category->description }}</td>
                    @endforeach
                    @foreach($reported->toolname as $name)
                    <td style="text-align:left; padding: 2px 5px;">{{ $name->description }}</td>
                    @endforeach
                    <td style="text-align:left; padding: 2px 5px;">{{ $reported->brand }}</td>
                    <td style="text-align:left; padding: 2px 5px;">{{ $reported->property }}</td>
                    @foreach($reported->toolroom as $room)
                    <td style="text-align:left; padding: 2px 5px;">{{ $room->code }}</td>
                    @endforeach
                    <td style="text-align:left; padding: 2px 5px;">{{ $reported->created_at }}</td>
                    <!-- @foreach($reported->tooladmin as $admin)
                    <td style="text-align:left; padding: 2px 5px;">{{ $admin->name }}</td>
                    @endforeach -->
                </tr>
            </tbody>
        @endforeach
        </table>
    </div>
    <div><br><br>
            <table border="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td colspan="2">Inventory by:</td>
                </tr>
                <tr>
                    <td><br><br> </td>
                    <td></td>
                </tr>
                <tr style="text-align:center; font-weight:500;">
                    <td style="text-transform:uppercase; text-decoration:underline;">________{{ Auth::user()->name }}________</td>
                    <td style="text-transform:uppercase;">{{ Auth::user()->name }}</td>
                </tr>
                <tr style="text-align:center;font-style: italic; font-size: 11pt;">
                    <td>(Printed Name and signature)</td>
                    <td>{{ Auth::user()->adminlte_desc() }}</td>
                </tr>
                <tr>
                    <td><br><br><br><br> </td>
                    <td></td>
                </tr>
                <tr style="text-align:center; margin-top:10px; font-weight:500;">
                    <td colspan="2">Prof. REMEGIO C. RIOS</td>
                </tr>
                <tr style="text-align:center; font-style: italic; font-size: 11pt;">
                    <td colspan="2">Laboratory Head</td>
                </tr>
            </table>
        </div> 
            
</body>

</html>