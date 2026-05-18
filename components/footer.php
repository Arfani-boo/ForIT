<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
?>
<footer style="
    background: white;
    border-top: 1px solid var(--gray-200, #e5e7eb);
    padding: 2rem;
    margin-top: 4rem;
    text-align: center;
">
    <div style="max-width:1200px;margin:0 auto;">
        <div style="display:flex;align-items:center;justify-content:center;gap:0.5rem;margin-bottom:0.75rem;">
            <div style="width:1.75rem;height:1.75rem;border-radius:8px;background:linear-gradient(135deg,#155DFC,#6366f1);color:white;font-weight:900;font-size:0.875rem;display:flex;align-items:center;justify-content:center;">F</div>
            <span style="font-weight:800;font-size:1.125rem;background:linear-gradient(135deg,#155DFC,#6366f1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">ForIT</span>
        </div>
        <p style="font-size:0.8125rem;color:var(--gray-400,#9ca3af);margin-bottom:0.5rem;">
            Forum Diskusi Teknologi Informasi · Universitas Trunojoyo Madura
        </p>
        <p style="font-size:0.775rem;color:var(--gray-300,#d1d5db);">
            &copy; <?= date('Y') ?> ForIT · Kelompok 2 · Program Studi Teknik Informatika UTM
        </p>
    </div>
</footer>