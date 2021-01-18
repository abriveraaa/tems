<!DOCTYPE html>
<html lang="en">
<style>
    @page{ margin: 10px; }
</style>
<body>
        <table width="100%">
                <tr>
                    <td>
                        <fieldset style="width:100%;">
                            <table border="0" cellpadding="1" cellspacing="0" style="padding:0;line-height:1;">
                                    <tr>
                                        <td rowspan="4"><img style="height:50px" src="http://localhost/tems/public/img/pup_logo.png"/></td>
                                        <td rowspan="4"></td>
                                        <td style="font-family: Calibri; font-size: 8pt">Republic of the Philippines</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 8pt;font-family: Californian FB;"><span style="font-size: 10pt;">P</span>OLYTECHNIC <span style="font-size: 10pt;">U</span>NIVERSITY OF THE <span style="font-size: 10pt;">P</span>HILIPPINES</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="font-size: 11pt;font-family: Californian FB;font-weight:400">INSTITUTE OF TECHNOLOGY</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 8pt;font-family: Californian FB;">LABORATORY OFFICE</td>
                                    </tr>
                            </table>
                            <table width="100%" border="0" cellpadding="1" cellspacing="0" style="font-size: 10.5pt;">
                                <tr>
                                    @foreach($lhofborrower as $lhofbor)
                                        @foreach($lhofbor->borrowers as $borrower)
                                        <td colspan="3" style="padding:2px 5px;">Name: <br><strong>{{ $borrower->lastname . ', '. $borrower->firstname }}</strong></td>
                                        <td colspan="2" style="padding:2px 5px; text-align:right;">Date & Time: <br><strong>{{ $lhofbor->created_at }}</strong></td>
                                        @endforeach
                                </tr>
                                    @foreach($lhofbor->borrowers as $borrower)
                                    @foreach($lhofbor->courses as $course)
                                <tr>
                                    <td style="padding:2px 5px;">Course: <br><strong>{{ $course->code . ' '. $borrower->year . '-'. $borrower->section }}</strong></td>
                                    @foreach($lhofbor->room as $borrower)
                                    <td colspan="2" style="padding:2px 5px; text-align:left;">Room: <br><strong>{{ $borrower->code }}</strong></td>
                                    <td colspan="3" style="padding:2px 5px; text-align:right;">LHOF No: <br><strong>{{ $lhofbor->lhof }}</strong></td>
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                </tr>
                            </table>
                            <table border="1" width="100%" cellpadding="1" cellspacing="0" style="font-size: 10.5pt;">
                                <thead>
                                    <tr>
                                        <th style="padding: 2px 5px;" width="10%">QTY</th>
                                        <th style="padding: 2px 5px;text-align:left;" colspan="4">ITEM</th>
                                    </tr>
                                </thead>
                                @foreach($lhofborrower as $lhof)
                                <tbody>
                                    <tr>
                                        <td style="padding: 2px 5px; text-align:center;">{{ $lhof->item_count}}</td>
                                        @foreach($lhof->item as $name)
                                        <td  style="padding: 2px 5px;" colspan="4">{{ $name->description }} </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>            
                            <table width="100%">
                                <tr>
                                    <td style="font-size:9pt;font-style:italic;font-weight:700;">I shall take full responsibility/ accountability in any tools/equipment. Likewise undertake that I will liable or any loss or damage/s of the above item/s.</td>
                                    </td>
                                </tr>
                                <tr>    
                                    @foreach($lhofborrower as $lhofbor)
                                    @foreach($lhofbor->borrowers as $borrower)
                                    <td style="text-transform:uppercase; text-align:center;font-size:10pt;font-weight:700;">
                                    {{ $borrower->lastname .', '. $borrower->firstname }}
                                    @endforeach
                                    @endforeach
                                    <hr>
                                    </td>
                                </tr>
                                <tr>
                                    @foreach($lhofborrower as $lhofbor)
                                    @foreach($lhofbor->borrowers as $borrower)

                                    <td style="font-style:italic; text-align:center;font-size:10pt;">Mobile Number: {{ $borrower->contact }}</td>
                                    @endforeach
                                    @endforeach

                                </tr>
                                <tr>
                                    <td># # # # # # # # # # # # # # # # # # # # # # # # # #</td>
                                </tr>
                                
                            </table>
                            <table width="100%" border="0" style="font-size:10pt;font-style:italic;">
                                <tr>
                                    <td>Returned by:</td>
                                    <td>Date & Time:</td>
                                </tr>
                                
                                <tr>
                                    @foreach($lhofborrower as $lhofbor)
                                    
                                    @foreach($lhofbor->returns as $borrower)
                                    <td style="text-transform:uppercase;font-style:normal;font-size:9pt;font-weight:700;">
                                    {{ $borrower->name }}
                                    </td>
                                    <td width="35%" style="text-transform:uppercase;font-style:normal;font-size:9pt;font-weight:700;">
                                        {{ $lhofbor->updated_at }} 
                                    </td>
                                    @endforeach
                                    @endforeach
                                </tr>
                                <tr>
                                <td colspan="2">Note: (Please present your identification card)</td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
            
</body>

</html>
