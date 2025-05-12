import.meta.glob(["../images/**"]);
import "bootstrap";
import "admin-lte";
import {
    OverlayScrollbars,
    ScrollbarsHidingPlugin,
    SizeObserverPlugin,
    ClickScrollPlugin,
} from "overlayscrollbars";

// resources/js/app.js
// import Alpine from 'alpinejs'

// window.Alpine = Alpine
// Alpine.start()




const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
const Default = {
    scrollbarTheme: "os-theme-light",
    scrollbarAutoHide: "leave",
    scrollbarClickScroll: true,
};

document.addEventListener("DOMContentLoaded", function () {
    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
    if (sidebarWrapper) {
        OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: Default.scrollbarTheme,
                autoHide: Default.scrollbarAutoHide,
                clickScroll: Default.scrollbarClickScroll,
            },
        });
    }
});


// import './bootstrap';

window.addEventListener('whatsapp-connected', () => {
    alert("WhatsApp conectado com sucesso!");
});

window.addEventListener("alert", (event) => {
    let data = event.detail;

    // Swal.fire({
    //     icon: data[0].icon,
    //     title: data[0].title,
    //     text: data[0].text,
    // });
    Swal.fire({
      icon: data[0].icon,
      title: data[0].title,
      text: data[0].text,
      width: 500,
      padding: '3em',
      color: '#fb7185', // Cor do texto
      background: '#fff',  // Fundo branco
      border: '2px solid #fb7185', // Borda com a cor da paleta (exemplo de cor amarela)
      iconColor: '#fb7185', // Cor do ícone
      confirmButtonColor: '#fb7185', // Cor do botão de confirmação
      showCloseButton: true,
      customClass: {
          popup: 'swal-popup-outline' // Classe personalizada para estilização adicional
      }
  });
  
  
});

window.addEventListener("confirm", (event) => {
    console.log("🚀 ~ window.addEventListener ~ event:", event)
    const { id, action, title, text, confirmButtonText, cancelButtonText } = event.detail[0];


    Swal.fire({
        title: title || "Tem certeza?",
        text: text || "Essa ação não poderá ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#fb7185",
        cancelButtonColor: "#9f1239",
        confirmButtonText: confirmButtonText || "Sim, deletar!",
        cancelButtonText: cancelButtonText || "Cancelar",
        color: "#fb7185",
        iconColor: "#fb7185",
        background: "#fff",
        customClass: {
            popup: 'swal-popup-outline'
        }
    }).then((result) => {
        console.log("🚀 ~ window.addEventListener ~ result:", result)
        if (result.isConfirmed) {
            Livewire.dispatch(action, { id: id });
        }
    });
});


window.addEventListener("qrCodeGenerated", (qrCodeUrl) => {

    // Este código será executado quando o evento for emitido e o QR Code for gerado
    console.log('QR Code generated:', qrCodeUrl);
    //  o DOM ou faça outras ações aqui, se necessário


});
