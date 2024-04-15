<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Web Libra International</title>
    </head>
    <body>
        <table width='700' height='222' border='0' align='center' cellpadding='5' cellspacing='0'>
            <tr>
                <td width='700' align='center' valign='middle'>
                    <img src="https://librainternational.com.pe/images/icons/logo.png" width='280' height='100' />
                </td>
            </tr>
            <tr>
                <td align='center' valign='middle' style='color:#000; font-size:18px; font-weight:bold'>Mensaje enviado desde la sección cotizar de la página web</td>
            </tr>
            <tr>
                <td align='center' valign='middle'>&nbsp;</td>
            </tr>
        </table>

        <table width='700' border='1' cellpadding='8' cellspacing='0' align='center'>
            <tr>
                <td align='center' colspan="1" style='font-weight:bold'>Nombre</td>
                <td align='center' >{{$contacto['nombre']}}</td>
            </tr>
            <tr>
                <td align='center' colspan="1" style='font-weight:bold'>Teléfono</td>
                <td align='center'>{{$contacto['telefono']}}</td>
            </tr>
            <tr>
                <td align='center' colspan="1" style='font-weight:bold'>Correo</td>
                <td align='center'>{{$contacto['correo']}}</td>
            </tr>
            <tr>
                <td align='center' colspan="1" style='font-weight:bold'>RUC</td>
                <td align='center'>{{$contacto['ruc']}}</td>
            </tr>
            <tr>
                <td align='center' colspan="1" style='font-weight:bold'>Maquinaria a cotizar</td>
                <td align='center'>{{$contacto['maquinaria']}}</td>
            </tr>

        </table>

        <table width='700' height='100' border='0' align='center' cellpadding='5' cellspacing='0'>
            <tr>
                <td align='center' valign='middle'>&nbsp;</td>
            </tr>
            <tr>
                <td align='center' valign='middle'>&nbsp;</td>
            </tr>
        </table>

    </body>
</html>