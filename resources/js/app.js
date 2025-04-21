import './bootstrap';

import * as bootstrap from 'bootstrap';

import html2canvas from 'html2canvas';

import '@fortawesome/fontawesome-free/css/all.min.css';

import '../css/app.css'; // Ensure Tailwind is included

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.getElementById("QrCodeBtn").onclick = function(){
    const QrCodeBadge = document.getElementById("QrCodeArea");

    html2canvas(QrCodeBadge).then((canvas) => {
            const DownloadName = canvas.toDataURL("image/png");
            var link = document.createElement('a');
            link.setAttribute("href", DownloadName);
            link.setAttribute("download", "Patient-QrCode.png");
            link.click();
            link.remove();
    });
}




