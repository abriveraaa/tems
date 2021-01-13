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
        <h3>LIST OF ACTIVE USER</h3>
    </div>
    
    <div>
        <table border="1" cellspacing="0" style="width:100%;">
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Contact</th>
                </tr>
            </thead>
        @foreach($activeborrower as $active)
            <tbody style="text-align:left;">
                <tr style="font-size:15px;">
                    <td width="20%">{{ $active->studnum }}</td>
                    <td>{{ ($active->midname == null) ? $active->lastname .', '. $active->firstname : $active->lastname .', '. $active->firstname .' '. $active->midname }}</td>
                    <td width="10%">{{ $active->sex }}</td>
                    @foreach($active->borrowercourse as $course)
                    <td width="13%">{{ $course->code . ' ' . $active->year .'-'. $active->section}}</td>
                    @endforeach
                    <td width="15%">{{ $active->contact }}</td>
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
                    <td style="text-transform:uppercase;">Mr. JAY A. PADILLA</td>
                </tr>
                <tr style="text-align:center;font-style: italic; font-size: 11pt;">
                    <td>(Printed Name and signature)</td>
                    <td>Administrative Staff</td>
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