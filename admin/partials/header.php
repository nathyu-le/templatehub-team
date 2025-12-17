<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_admin();

$admin = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <style>
    :root{ --side:260px; }
    body{ background:#f6f7fb; }
    .admin-shell{ display:flex; min-height:100vh; }
    .admin-sidebar{
      width:var(--side);
      background:#fff;
      border-right:1px solid #eee;
      position:sticky; top:0; height:100vh;
      padding:18px;
    }
    .admin-brand{
      font-weight:900; letter-spacing:.6px;
      display:flex; align-items:center; gap:10px;
      margin-bottom:18px;
    }
    .admin-brand .dot{
      width:10px; height:10px; border-radius:99px;
      background:#111;
    }
    .admin-nav a{
      display:flex; align-items:center; gap:10px;
      padding:10px 12px;
      border-radius:12px;
      text-decoration:none;
      color:#111;
      font-weight:600;
      opacity:.88;
    }
    .admin-nav a:hover{ background:#f4f5f7; opacity:1; }
    .admin-topbar{
      background:#fff;
      border-bottom:1px solid #eee;
      padding:14px 18px;
      border-radius:16px;
    }
    .admin-content{ flex:1; padding:18px; }
    .cardx{
      background:#fff; border:1px solid #eee; border-radius:16px;
      box-shadow:0 10px 30px rgba(0,0,0,.04);
    }
    .stat{
      padding:16px;
      border-radius:16px;
      border:1px solid #eee;
      background:#fff;
    }
    .stat .k{ color:#6c757d; font-size:12px; }
    .stat .v{ font-size:28px; font-weight:900; }
    .table thead th{ background:#fafafa; }
    .pill{
      display:inline-block; padding:6px 10px; border-radius:999px;
      font-size:12px; font-weight:700;
      border:1px solid #eee;
    }
    .pill.ok{ background:#eaf7ef; border-color:#cfeedd; color:#137a3d;}
    .pill.no{ background:#f1f3f5; color:#495057;}
    .pill.warn{ background:#fff5e6; border-color:#ffe2b3; color:#a15b00;}
    .pill.bad{ background:#ffecef; border-color:#ffc9d2; color:#b42318;}
    .btn-ceo{ border-radius:12px; font-weight:700; }
  </style>
</head>
<body>
<div class="admin-shell">
