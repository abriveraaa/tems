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
        <h3>INVENTORY CONTROL FORM</h3>
    </div>
    <div>Inventory Date:<span style="font-weight: 500; text-decoration: underline;"> {{ $date }}<br><br></div>
    
    <div>
        <table border="1" cellspacing="0" style="width:100%;">
            <thead>
                <tr>
                    <th rowspan="3" style="text-align:center">Quantity <br>As Of Prior<br> Inventory</th>
                    <th rowspan="3" style="width:20%">Item Category</th>
                    <th rowspan="3" style="width:20%">Item Name</th>
                    <th colspan="3" style="text-align:center">Changes Prior Inventory</th>
                    <th rowspan="3" style="text-align:center">Quantity  <br>on Hand</th>
                </tr>
                <tr>
                    <th rowspan="2" style="text-align:center">Quantity <br> Added</th>
                    <th colspan="2" style="text-align:center">Quantity Deleted</th>
                </tr>
                <tr>
                    <th style="text-align:center">Lost</th>
                    <th style="text-align:center">Damaged</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $use)
                <tr>
                    <td style="text-align:center">{{ $use->previous }}</td>
                    <td>{{ $use->category }}</td>
                    <td>{{ $use->itemname }}</td>
                    <td style="text-align:center">{{ $use->quantityadded }}</td>
                    <td style="text-align:center">{{ $use->lost_count }}</td>
                    <td style="text-align:center">{{ $use->damaged_count }}</td>
                    <td style="text-align:center">{{ $use->quantityonhand }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div><br><br>
            <table border="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td colspan="2">Prepared by:</td>
                </tr>
                <tr>
                    <td><br><br> </td>
                    <td></td>
                </tr>
                <tr style="text-align:center; font-weight:500;">
                    <td style="text-transform:uppercase; text-decoration:underline;">________{{ Auth::user()->name }}________</td>
                    <td style="text-transform:uppercase;">Mr. JAY A. PADILLA</td>
                </tr>
                <tr style="text-align:center;font-style: italic; font-size: 11pt;">
                    <td>(Printed Name and signature)</td>
                    <td>Laboratory Staff</td>
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
