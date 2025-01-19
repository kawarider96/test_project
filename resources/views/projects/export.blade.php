<div style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
    <!-- Export Period and Created At -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="font-weight: bold; padding: 8px; border: 1px solid #ccc;">Export period:</td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exportPeriod['start'] }} - {{ $exportPeriod['end'] }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; padding: 8px; border: 1px solid #ccc;">Created at:</td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ now()->format('Y-m-d H:i:s') }}</td>
        </tr>
    </table>

    <!-- Project Totals -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Project</th>
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projectTotals as $project)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $project['name'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $project['total_time'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detailed Times -->
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Project</th>
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Start</th>
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Finish</th>
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Duration</th>
                <th style="text-align: left; padding: 10px; border: 1px solid #ccc;">Memo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($times as $time)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $time['project_name'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $time['start'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $time['finish'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $time['duration'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $time['comment'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
