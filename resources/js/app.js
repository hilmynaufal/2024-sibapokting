import './bootstrap';

document.addEventListener('livewire:navigated', () => { 
    console.log("Navigasi");
    initFlowbite();
});