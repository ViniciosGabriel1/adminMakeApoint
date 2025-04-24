import.meta.glob(["../images/**"]);
import "bootstrap";
import "admin-lte";
import {
    OverlayScrollbars,
    ScrollbarsHidingPlugin,
    SizeObserverPlugin,
    ClickScrollPlugin,
} from "overlayscrollbars";

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
    const id_registro = event.detail.id;

    // Swal.fire({
    //     title: "Tem certeza?",
    //     text: "Essa ação não poderá ser desfeita!",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#d33",
    //     cancelButtonColor: "#6c757d",
    //     confirmButtonText: "Sim, deletar!",
    //     cancelButtonText: "Cancelar",
    // }).then((result) => {
    //     if (result.isConfirmed) {
    //         Livewire.dispatch("delete", { id: ClientId });
    //     }
    // });

    Swal.fire({
      title: "Tem certeza?",
      text: "Essa ação não poderá ser desfeita!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#fb7185", // Rosa para o botão de confirmação
      cancelButtonColor: "#9f1239",  // Rosa claro para o botão de cancelar (ou um tom neutro)
      confirmButtonText: "Sim, deletar!",
      cancelButtonText: "Cancelar",
      color: "#fb7185", // Cor do texto
      iconColor: "#fb7185", // Cor do ícone
      background: "#fff", // Fundo branco
      customClass: {
          popup: 'swal-popup-outline' // Classe opcional para personalizações extras via CSS
      }
  }).then((result) => {
      if (result.isConfirmed) {
          Livewire.dispatch("delete", { id: id_registro });
      }
  });
  
});
