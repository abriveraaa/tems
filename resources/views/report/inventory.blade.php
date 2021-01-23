<!DOCTYPE html>
<html lang="en">

<body>
    <table width="100%"  cellspacing="1" cellpadding="0"; style="border-collapse: collapse; line-height:1;">
        <tr>
            <td rowspan="5" style="width: 10%;"><img src="http://localhost/tems/public/img/pup_logo.png"/></td>
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
        <h3>TOOLS AND EQUIPMENT INVENTORY CONTROL FORM</h3>
    </div>
    <div>Inventory Date:<span style="font-weight: 500; text-decoration: underline;"> {{ $date }}<br><br></div>
    
    <div>
        <table border="1" cellspacing="0" style="width:100%;">
            <thead>
                <tr>
                    <th rowspan="3" style="text-align:center">Quantity <br>As Of Prior<br> Inventory</th>
                    <th rowspan="3" style="width:40%">Item Name</th>
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
            <tbody style="">
                @foreach($data as $key => $value )
                    <tr style="background-color: #fff;">
                        <td style="border-right: 0px;"></td>
                        <td colspan="5" style="border-left: 0px; font-weight: 500; padding:3px; ">{{ $key }}</td>
                    </tr>
                    @foreach($value as $category )
                    <tr>
                        <td style="text-align:center; padding:3px;">{{ $category->previous }}</td>
                        <td style="padding:3px;">{{ $category->itemname }}</td>
                        <td style="text-align:center; padding:3px;">{{ $category->quantityadded }}</td>
                        <td style="text-align:center; padding:3px;">{{ $category->lost_count }}</td>
                        <td style="text-align:center; padding:3px;">{{ $category->damaged_count }}</td>
                        <td style="text-align:center; padding:3px;">{{ $category->quantityonhand }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
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
            <tr>
                <td style="text-align:left; font-weight:500; text-transform:uppercase; text-decoration:underline;">______________________</td>
                @if($staff == null)
                <td style="text-transform:uppercase;"></td>
                @else
                <td style="text-align:center; font-weight:500; text-transform:uppercase;">{{ $staff->name }}</td>
                @endif
            </tr>
            <tr>
                <td style="text-align:left;font-style: italic; font-size: 11pt;">(Printed Name and signature)</td>
                @if($staff == null)
                <td style="text-align:center; text-transform:uppercase;"></td>
                @else
                <td style="text-align:center;font-style: italic; font-size: 11pt;">{{ $staff->position }}</td>
                @endif
            </tr>
            <tr>
                <td><br><br><br><br> </td>
                <td></td>
            </tr>
            @if ($head == null)
            <tr style="text-align:center; margin-top:10px; font-weight:500; text-transform:uppercase;">
                <td colspan="2"></td>
            </tr>
            <tr style="text-align:center; font-style: italic; font-size: 11pt;">
                <td colspan="2"></td>
            </tr>
            @else    
            <tr style="text-align:center; margin-top:10px; font-weight:500; text-transform:uppercase;">
                <td colspan="2">Prof. {{ $head->name }}</td>
            </tr>
            <tr style="text-align:center; font-style: italic; font-size: 11pt;">
                <td colspan="2">{{ $head->position }}</td>
            </tr>
            @endif
        </table>
    </div>     
</body>
</html>
