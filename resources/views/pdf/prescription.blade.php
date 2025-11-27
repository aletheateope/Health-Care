@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription for {{ $prescription->patient->profile->first_name }} {{
        $prescription->patient->profile->last_name }}</title>

    <style>
        @page {
            margin-top: 420px;
            margin-bottom: 240px;
            margin-left: 50px;
            margin-right: 50px;
        }

        * {
            box-sizing: border-box;
        }

        header {
            position: fixed;
            top: -380px;
            left: 0px;
            right: 0px;
        }

        footer {
            position: fixed;
            bottom: -150px;
            left: 0px;
            right: 0px;
        }

        main {
            margin-top: 0rem;
            margin-bottom: 0px;
        }

        .doctor-container {
            width: 15rem;
            margin-left: auto;
            text-align: center;
        }

        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <table style=" text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 1rem">
            <tbody>
                <tr>
                    <td>XYZ Company</td>
                </tr>
                <tr>
                    <td>Address</td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                </tr>
            </tbody>
        </table>
        <h3 style="text-align: center; margin-bottom: 2rem;">Prescription ID: {{ $prescription->ref_id }}</h3>
        <table style=" border-collapse: collapse; margin-bottom: 1.5rem;">
            <tbody>
                <tr>
                    <th style="text-align: left">Date Issued</th>
                    <th style="text-align: left">Valid Until</th>
                </tr>
                <tr style="border-bottom: 1px solid black">
                    <td style="padding-bottom: 1rem;">
                        {{ Carbon::parse($prescription->date_created)->format('F j, Y') }}
                    </td>
                    <td style="padding-bottom: 1rem;">
                        {{ Carbon::parse($prescription->valid_until)->format('F j, Y') }}
                    </td>
                </tr>
                <tr>
                    <th style="text-align: left; padding-top: 1rem;">Patient Name</th>
                    <th style="text-align: left; padding-top: 1rem;">Age</th>
                </tr>
                <tr>
                    <td>{{ $prescription->patient->profile->first_name }} {{ $prescription->patient->profile->last_name
                        }}
                    </td>
                    <td>
                        {{ Carbon::parse($prescription->patient->profile->date_of_birth)->age }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="width: 4rem; height:4rem;">
            <img src="{{ public_path('img/rx-icon.png') }}" alt="" style="width:100%; height:100%;">
        </div>
    </header>
    <footer>
        <div class="doctor-container">
            <table style="text-align: center; ">
                <tbody>
                    <tr>
                        <td style="border-bottom:1px solid black;"></td>
                    </tr>
                    <tr>
                        <td> Dr. {{$prescription->doctor->profile->first_name}}
                            {{$prescription->doctor->profile->last_name}}
                        </td>
                    </tr>
                    <tr>
                        <td>License No.: {{ $prescription->doctor->license_number ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </footer>
    <main>
        <table style="margin-bottom: 2rem;">
            <thead>
                <tr>
                    <th style="text-align: left">Items</th>
                    <th style="text-align: left">Quantity</th>
                    <th style="text-align: left">Sig.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescription->items as $item)
                <tr>
                    <td>{{ $item->item }}</td>
                    <td style="width: 10rem;">{{ $item->quantity }}</td>
                    <td>{{ $item->sig }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th style="text-align: left;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescription->remarks as $remark)
                <tr>
                    <td>{{ $remark->remark }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 10;
            $x = 40;
            $y = $pdf->get_height() - 50;
            $pageText = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $pdf->page_text($x, $y, $pageText, $font, $size);
        }
    </script>
</body>

</html>