<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <style>
            .tr {
                display: table-cell;
            }

            .td {
                display: block;
            }

        </style>
        <div class="pt-8 sm:pt-0">
            <h1>statistics</h1><br>
            <form id="form" action="/stats" method="POST">
                @csrf
                <select name="report_name" id="report-name">
                    <option disabled hidden selected>Please choose a report name</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select name="report_by" id="report-by"></select>
                <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
            </form>
            <table>
                <tr>
                    <th>City</th>
                    <th>A+</th>
                    <th>A-</th>
                    <th>B+</th>
                    <th>B-</th>
                    <th>AB+</th>
                    <th>AB-</th>
                    <th>O+</th>
                    <th>O-</th>
                </tr>
                <tr class="tr">
                    @for ($i = 0; $i < count($cities); $i++)
                        <td class="td">{{ $cities[$i] }}</td>
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[0][$j]))
                            @if ($data[0][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[0][$j]['A_plus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[1][$j]))
                            @if ($data[1][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[1][$j]['A_minus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[2][$j]))
                            @if ($data[2][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[2][$j]['B_plus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[3][$j]))
                            @if ($data[3][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[3][$j]['B_minus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[4][$j]))
                            @if ($data[4][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[4][$j]['AB_plus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[5][$j]))
                            @if ($data[5][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[5][$j]['AB_minus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[6][$j]))
                            @if ($data[6][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[6][$j]['O_plus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
                <tr class="tr">
                    @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                        @if (isset($data[7][$j]))
                            @if ($data[7][$j]['city'] == $cities[$i])
                                <td class="td">{{ $data[7][$j]['O_minus'] }}</td>
                            @else
                                @php $j--; @endphp
                                <td class="td">0</td>
                            @endif
                        @else
                            <td class="td">0</td>
                        @endif
                    @endfor
                </tr>
            </table>
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
