

import.meta.glob([
  '../images/**'
]);
import 'bootstrap';
import 'admin-lte';
import { 
    OverlayScrollbars, 
    ScrollbarsHidingPlugin, 
    SizeObserverPlugin, 
    ClickScrollPlugin 
  } from 'overlayscrollbars';


  const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
  const Default = {
    scrollbarTheme: 'os-theme-light',
    scrollbarAutoHide: 'leave',
    scrollbarClickScroll: true,
  };

  document.addEventListener('DOMContentLoaded', function () {
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

window.addEventListener('alert',(event) =>{

    let data = event.detail;

        Swal.fire({
            icon:data[0].icon,
            title:data[0].title,
            text:data[0].text,
        })

    
})

window.addEventListener('confirm',(event) =>{
console.log("🚀 ~ window.addEventListener ~ event:", event)

    const ClientId = event.detail.ClientId;
    console.log("🚀 ~ window.addEventListener ~ ClientId:", ClientId)

    Swal.fire({
        title: 'Tem certeza?',
        text: 'Essa ação não poderá ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('deleteClient', { id: ClientId });
           
        }
    });

       

    
})




