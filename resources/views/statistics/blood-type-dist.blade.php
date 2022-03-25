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
            @if (isset($data_by_city))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
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
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        <tr class="tr">
                            @for ($i = 0; $i < count($cities); $i++)
                                <td class="td">{{ $cities[$i] }}</td>
                            @endfor
                        </tr>
                        @for ($k = 0; $k < 8; $k++)
                            <tr class="tr">
                                @for ($i = 0, $j = 0; $i < count($cities); $i++, $j++)
                                    @if (isset($data_by_city[$k][$j]))
                                        @if ($data_by_city[$k][$j]['city'] == $cities[$i])
                                            <td class="td">{{ $data_by_city[$k][$j][$blood_types[$k]] }}
                                            </td>
                                        @else
                                            @php $j--; @endphp
                                            <td class="td">0</td>
                                        @endif
                                    @else
                                        <td class="td">0</td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </table>
                </div>
            @elseif(isset($data_by_age))
                <h1>{{ $report_title }}</h1>
                @php
                    $ages = ['Children', 'Elder', 'Youth'];
                @endphp
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Age segment</th>
                            <th>A+</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B-</th>
                            <th>AB+</th>
                            <th>AB-</th>
                            <th>O+</th>
                            <th>O-</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        <tr class="tr">
                            <td class="td">Children</td>
                            <td class="td">Elder</td>
                            <td class="td">Youth</td>
                        </tr>
                        @for ($k = 0; $k < 8; $k++)
                            <tr class="tr">
                                @for ($i = 0, $j = 0; $i < count($ages); $i++, $j++)
                                    @if (isset($data_by_age[$k][$j]))
                                        @if ($data_by_age[$k][$j]['age'] == $ages[$i])
                                            <td class="td">{{ $data_by_age[$k][$j][$blood_types[$k]] }}
                                            </td>
                                        @else
                                            @php $j--; @endphp
                                            <td class="td">0</td>
                                        @endif
                                    @else
                                        <td class="td">0</td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </table>
                </div>
            @elseif(isset($data_by_blood))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Blood type</th>
                            <th>Total persons from this type</th>
                            <th>Percentage of this type</th>
                            <th>Male percentage</th>
                            <th>Female percentage</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @for ($i = 0; $i < count($data_by_blood); $i++)
                            <tr>
                                @foreach ($data_by_blood[$i] as $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endfor
                    </table>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
