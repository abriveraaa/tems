<!DOCTYPE html>
<html lang="en">

<body>
    @include('report.header')
    <div style="margin-top:2rem; text-align: center; text-transform: uppercase;font-family: Calibri;">
        <h3>LIST OF BANNED USER</h3>
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
        @foreach($bannedborrower as $banned)
            <tbody style="text-align:left;">
                <tr style="font-size:15px;">
                    <td width="20%">{{ $banned->studnum }}</td>
                    <td>{{ ($banned->midname == null) ? $banned->lastname .', '. $banned->firstname : $banned->lastname .', '. $banned->firstname .' '. $banned->midname }}</td>
                    <td width="10%">{{ $banned->sex }}</td>
                    @foreach($banned->borrowercourse as $course)
                    <td width="13%">{{ $course->code . ' ' . $banned->year .'-'. $banned->section}}</td>
                    @endforeach
                    <td width="15%">{{ $banned->contact }}</td>
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
