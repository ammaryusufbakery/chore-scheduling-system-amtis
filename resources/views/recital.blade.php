<x-app-layout>
    <table>
        <tr>
            <th></th>
            <th>Isnin</th>
            <th>Selasa</th>
            <th>Rabu</th>
            <th>Khamis</th>
            <th>Jumaat</th>
        </tr>

        <tr>
            <th>Minggu 1</th>
            @foreach ($week1 as $week)
                <td>{{ $week->junior->name }}</td>
            @endforeach
        </tr>

        <tr>
            <th>Minggu 2</th>
            @foreach ($week2 as $week)
                <td>{{ $week->junior->name }}</td>
            @endforeach
        </tr>

        <tr>
            <th>Minggu 3</th>
            @foreach ($week3 as $week)
                <td>{{ $week->junior->name }}</td>
            @endforeach
        </tr>

        <tr>
            <th>Minggu 4</th>
            @foreach ($week4 as $week)
                <td>{{ $week->junior->name }}</td>
            @endforeach
        </tr>
    </table>
</x-app-layout>