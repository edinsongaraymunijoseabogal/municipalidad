<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header,
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }

        .header {
            top: 0px;
            border-bottom: 2px solid #0073b7;
            padding-bottom: 10px;
        }

        .footer {
            bottom: 0px;
            font-size: 10px;
            border-top: 2px solid #0073b7;
            padding-top: 10px;
        }

        .footer .page-number {
            float: right;
        }

        .footer .page-number:before {
            content: "Página " counter(page);
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #004080;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #0073b7;
            color: white;
            font-size: 12px;
        }

        td {
            font-size: 11px;
        }

        .blue-bg {
            background-color: #E5F3FF;
        }

        .column-name {
            width: 30%;
        }

        .column-organizational-unit {
            width: 20%;
        }

        .column-position {
            width: 20%;
        }

        .column-phone {
            width: 15%;
        }

        .column-email {
            width: 15%;
        }
    </style>
</head>

<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td width="20%" style="text-align: center">
                    <img src="{{ public_path('images/logo.png') }}" class="logo">
                </td>
                <td width="60%" class="title">
                    Directorio de Usuarios - {{ config('app.name') }}
                </td>
                <td width="20%" style="text-align: right; font-size: 1rem">
                    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="content" style="margin-top: 150px;">
        @foreach ($groupedUsers as $organizationalUnit => $users)
            <h2 style="margin-top: 20px;">{{ $organizationalUnit }}</h2>
            <table>
                <thead>
                    <tr>
                        <th class="column-name">Apellidos y Nombres</th>
                        <th class="column-organizational-unit">Unidad Orgánica</th>
                        <th class="column-position">Cargo</th>
                        <th class="column-phone">Teléfono Central</th>
                        <th class="column-email">Correo Institucional</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="{{ $loop->even ? 'blue-bg' : '' }}">
                            <td class="column-name">{{ $user->name }}</td>
                            <td class="column-organizational-unit">{{ $user->organizational_unit->name }}</td>
                            <td class="column-position">{{ $user->position->name ?? 'Sin posición' }}</td>
                            <td class="column-phone">
                                <a href="tel:{{ $user->central_phone }}">{{ $user->central_phone ?? '-' }}</a>
                            </td>
                            <td class="column-email">
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>

    <div class="footer">
        <div class="page-number"></div>
    </div>

</body>

</html>
