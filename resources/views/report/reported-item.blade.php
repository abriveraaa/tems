<!DOCTYPE html>
<html lang="en">

<body>
    @include('report.header')
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
                    <th>Source</th>
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
                    @foreach($reported->toolsource as $source)
                    <td style="text-align:left; padding: 2px 5px;">{{ $source->description }}</td>
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
