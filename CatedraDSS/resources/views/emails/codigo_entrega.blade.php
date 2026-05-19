<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recogida — FoodShare</title>
</head>
<body style="margin:0; padding:0; background-color:#f0f4f8; font-family:'Segoe UI', Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">

                    <tr>
                        <td style="background: linear-gradient(135deg, #45b66f, #2d8c52); padding: 36px 40px; text-align:center;">
                            <h1 style="color:#ffffff; font-size:22px; font-weight:800; margin:12px 0 4px 0;">
                                Tienes una recogida asignada
                            </h1>
                            <p style="color:rgba(255,255,255,0.85); font-size:14px; margin:0;">
                                Hola, <strong>{{ $nombreVoluntario }}</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 36px 40px;">

                            <p style="font-size:15px; color:#4a5568; margin:0 0 28px 0;">
                                Se te ha asignado la recogida del siguiente producto. Preséntate en el comercio indicado y
                                muestra tu <strong>código de verificación</strong> al llegar.
                            </p>

                            
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f7fdf9; border:1px solid #c6f0d6; border-radius:12px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 4px 0; font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#45b66f; font-weight:700;">
                                            Lugar de recogida
                                        </p>
                                        <p style="margin:0; font-size:18px; font-weight:800; color:#1a2a32;">
                                            {{ $nombreComercio }}
                                        </p>
                                        <p style="margin:6px 0 0 0; font-size:13px; color:#718096;">
                                            {{ $direccionComercio }}
                                        </p>
                                        @if($horarioComercio)
                                        <p style="margin:4px 0 0 0; font-size:13px; color:#718096;">
                                            Horario: {{ $horarioComercio }}
                                        </p>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff8f0; border:1px solid #fde8c8; border-radius:12px; margin-bottom:28px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 4px 0; font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#e07a20; font-weight:700;">
                                            Producto a recoger
                                        </p>
                                        <p style="margin:0; font-size:18px; font-weight:800; color:#1a2a32;">
                                            {{ $tituloDonacion }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                                <tr>
                                    <td align="center" style="background: linear-gradient(135deg, #1a2a32, #2d3f4d); border-radius:16px; padding:32px;">
                                        <p style="margin:0 0 8px 0; font-size:12px; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,0.6);">
                                            Tu código de verificación
                                        </p>
                                        <p style="margin:0; font-size:56px; font-weight:900; color:#45b66f; letter-spacing:12px; font-family:'Courier New', monospace;">
                                            {{ $codigo }}
                                        </p>
                                        <p style="margin:12px 0 0 0; font-size:12px; color:rgba(255,255,255,0.5);">
                                            Muestra este código en el comercio al momento de recoger
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:13px; color:#a0aec0; text-align:center; margin:0;">
                                Este código es de un solo uso. No lo compartas con nadie más.
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f7fdf9; padding:20px 40px; text-align:center; border-top:1px solid #e8f5e9;">
                            <p style="margin:0; font-size:12px; color:#a0aec0;">
                                © {{ date('Y') }} <strong style="color:#45b66f;">FoodShare</strong> — Conectando excedentes con quienes más los necesitan
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
