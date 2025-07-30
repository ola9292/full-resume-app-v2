<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->name ?? 'Resume' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 20px;
        }

        .resume-container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header */
        .resume-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .role {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }

        .contact-info {
            font-size: 11px;
            color: #333;
        }

        /* Sections */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin-bottom: 10px;
        }

        .summary-text {
            font-size: 14px;
            text-align: justify;
            color: #333;
        }

        /* Skills */
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .skill-pill {
            background: #000;
            color: #fff;
            padding: 3px 8px 5px 8px;
            border-radius: 10px;
            font-size: 12px;
            display: inline-block;
        }

        /* job_Experience & Education */
        .item {
            border-left: 2px solid #000;
            padding-left: 10px;
            margin-bottom: 15px;
        }

        .item-header {
            width: 100%;
            margin-bottom: 5px;
        }

        .item-header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .item-header-table td {
            vertical-align: top;
            padding: 0;
            border: none;
        }

        .item-info-cell {
            width: 70%;
        }

        .item-dates-cell {
            width: 30%;
            text-align: right;
        }

        .item-title {
            font-size: 13px;
            font-weight: bold;
            line-height: 1.2;
            margin: 0;
        }

        .item-subtitle {
            font-size: 14px;
            color: #333;
            font-style: italic;
            margin: 0;
            line-height: 1.2;
        }

        .item-dates {
            font-size: 10px;
            color: #333;
            font-weight: bold;
            text-align: right;
            white-space: nowrap;
            line-height: 1.2;
            margin: 0;
        }

        .item-skills {
            font-size: 10px;
            color: #333;
            margin-bottom: 5px;
        }

        .item-description {
            font-size: 14px;
            color: #333;
            text-align: justify;
            margin-left: 8px;
            /* white-space: pre-line; */
        }

        /* Page break handling */
        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        /* Print-specific styles */
        @media print {
            .item-header-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .item-header-table td {
                vertical-align: top !important;
                padding: 0 !important;
                border: none !important;
            }

            .item-info-cell {
                width: 70% !important;
            }

            .item-dates-cell {
                width: 30% !important;
                text-align: right !important;
            }
        }
    </style>
</head>
<body>
    <div class="resume-container">
        <!-- Header -->
        <div class="resume-header">
            <h1 class="name">{{ $resume->name ?? 'Your Name' }}</h1>
            <h2 class="role">{{ $resume->role ?? 'Your Role' }}</h2>
            <div class="contact-info">
                @php
                    $contacts = array_filter([
                        $resume->email,
                        $resume->phone,
                        $resume->location,
                        $resume->website
                    ]);
                @endphp
                {{ implode(' | ', $contacts) }}
            </div>
        </div>

        <!-- Summary -->
        @if($resume->summary)
        <div class="section no-break">
            <h3 class="section-title">Summary</h3>
            <p class="summary-text">{{ $resume->summary }}</p>
        </div>
        @endif

        <!-- Skills -->
        @if($resume->skills && is_array($resume->skills) && count($resume->skills) > 0)
        <div class="section no-break">
            <h3 class="section-title">Skills</h3>
            <div class="skills-container">
                @foreach($resume->skills as $skill)
                    @if(is_array($skill) && !empty($skill['title']))
                        <span class="skill-pill">{{ $skill['title'] }}</span>
                    @elseif(is_string($skill) && !empty($skill))
                        <span class="skill-pill">{{ $skill }}</span>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Experience -->
        @if($resume->job_experience && is_array($resume->job_experience) && count($resume->job_experience) > 0)
        <div class="section">
            <h3 class="section-title">Experience</h3>
            @foreach($resume->job_experience as $job)
                @if(!empty($job['company']) || !empty($job['position']))
                <div class="item no-break">
                    <div class="item-header">
                        <table class="item-header-table">
                            <tr>
                                <td class="item-info-cell">
                                    <div class="item-title">{{ $job['position'] ?? 'Position' }}</div>
                                    <div class="item-subtitle">{{ $job['company'] ?? 'Company' }}</div>
                                </td>
                                <td class="item-dates-cell">
                                    <div class="item-dates">
                                        @php
                                            $start = $job['start'] ?? '';
                                            $end = $job['end'] ?? 'Present';
                                            $dateRange = $start;
                                            if ($start && $end) {
                                                $dateRange = $start . ' - ' . $end;
                                            } elseif ($end && $end !== 'Present') {
                                                $dateRange = $end;
                                            } elseif (!$start && $end === 'Present') {
                                                $dateRange = 'Present';
                                            }
                                        @endphp
                                        {{ $dateRange }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if(!empty($job['skills']))
                        <div class="item-skills"><strong>Skills:</strong> {{ $job['skills'] }}</div>
                    @endif
                    @if(!empty($job['description']))
                        {{-- <div class="item-description">{{ $job['description'] }}</div> --}}
                        <ul style="margin-left: 4px">
                            @foreach(explode("\n", $job['description']) as $line)
                                <li class="item-description">{{ $line }}</li>
                            @endforeach
                        </ul>

                    @endif
                </div>
                @endif
            @endforeach
        </div>
        @endif

        <!-- Education -->
        @if($resume->education && is_array($resume->education) && count($resume->education) > 0)
        <div class="section">
            <h3 class="section-title">Education</h3>
            @foreach($resume->education as $edu)
                @if(!empty($edu['school']) || !empty($edu['course']))
                <div class="item no-break">
                    <div class="item-header">
                        <table class="item-header-table">
                            <tr>
                                <td class="item-info-cell">
                                    <div class="item-title">{{ $edu['course'] ?? 'Course' }}</div>
                                    <div class="item-subtitle">{{ $edu['school'] ?? 'School' }}</div>
                                </td>
                                <td class="item-dates-cell">
                                    <div class="item-dates">
                                        @php
                                            $start = $edu['start'] ?? '';
                                            $end = $edu['end'] ?? 'Present';
                                            $dateRange = $start;
                                            if ($start && $end) {
                                                $dateRange = $start . ' - ' . $end;
                                            } elseif ($end && $end !== 'Present') {
                                                $dateRange = $end;
                                            } elseif (!$start && $end === 'Present') {
                                                $dateRange = 'Present';
                                            }
                                        @endphp
                                        {{ $dateRange }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</body>
</html>