<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .field:last-child {
            border-bottom: none;
        }
        .field-label {
            font-weight: 600;
            color: #1f2937;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .field-value {
            color: #4b5563;
            font-size: 15px;
        }
        .message-box {
            background-color: #f9fafb;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            border-radius: 4px;
            margin-top: 8px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            background-color: #dbeafe;
            color: #1e40af;
        }
        .meta-info {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Pesan Baru dari Contact Form</h1>
        </div>
        
        <div class="content">
            <p style="color: #6b7280; margin-bottom: 25px;">
                Anda menerima pesan baru dari formulir kontak website Visi Yosindo Medikal:
            </p>
            
            <div class="field">
                <div class="field-label">Nama Lengkap</div>
                <div class="field-value">{{ $submission->name }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">Email</div>
                <div class="field-value">
                    <a href="mailto:{{ $submission->email }}" style="color: #3b82f6; text-decoration: none;">
                        {{ $submission->email }}
                    </a>
                </div>
            </div>
            
            @if($submission->phone)
            <div class="field">
                <div class="field-label">No. Telepon</div>
                <div class="field-value">
                    <a href="tel:{{ $submission->phone }}" style="color: #3b82f6; text-decoration: none;">
                        {{ $submission->phone }}
                    </a>
                </div>
            </div>
            @endif
            
            @if($submission->company)
            <div class="field">
                <div class="field-label">Perusahaan / Institusi</div>
                <div class="field-value">{{ $submission->company }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="field-label">Subjek</div>
                <div class="field-value">
                    <span class="badge">{{ $submission->subject_label }}</span>
                </div>
            </div>
            
            <div class="field">
                <div class="field-label">Pesan</div>
                <div class="message-box">
                    {!! nl2br(e($submission->message)) !!}
                </div>
            </div>
            
            <div class="meta-info">
                <strong>Informasi Tambahan:</strong><br>
                <strong>Waktu:</strong> {{ $submission->created_at->format('d M Y, H:i') }} WIB<br>
                <strong>IP Address:</strong> {{ $submission->ip_address }}<br>
                <strong>User Agent:</strong> {{ Str::limit($submission->user_agent, 100) }}
            </div>
        </div>
        
        <div class="footer">
            <p style="margin: 0;">
                Email ini dikirim otomatis dari sistem.<br>
                Untuk membalas, gunakan tombol "Reply" dengan email yang tertera di atas.
            </p>
            <p style="margin: 10px 0 0 0; font-size: 11px;">
                &copy; {{ date('Y') }} PT Visi Yosindo Medikal. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
