<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Maintenance Mode</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #1a103c 0%, #2d1b69 50%, #1a103c 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      padding: 24px;
    }
    .maintenance-card {
      background: rgba(255,255,255,0.06);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 20px;
      padding: 60px 48px;
      max-width: 520px;
      width: 100%;
      text-align: center;
    }
    .icon {
      font-size: 64px;
      margin-bottom: 20px;
      display: block;
    }
    h1 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 12px;
      font-family: 'Georgia', serif;
    }
    p {
      font-size: 15px;
      line-height: 1.7;
      color: rgba(255,255,255,0.7);
      margin-bottom: 8px;
    }
    .badge {
      display: inline-block;
      margin-top: 24px;
      padding: 6px 16px;
      border-radius: 100px;
      background: rgba(214,51,132,0.2);
      color: #ff6b9d;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    @media (max-width: 480px) {
      .maintenance-card { padding: 40px 24px; }
      h1 { font-size: 22px; }
    }
  </style>
</head>
<body>
  <div class="maintenance-card">
    <span class="icon">🔧</span>
    <h1>Sedang Dalam Perbaikan</h1>
    <p>Website sedang dalam masa pemeliharaan. Kami akan segera kembali.</p>
    <p style="font-size:13px; color: rgba(255,255,255,0.45);">Terima kasih atas kesabaran Anda.</p>
    <span class="badge">Maintenance Mode</span>
  </div>
</body>
</html>