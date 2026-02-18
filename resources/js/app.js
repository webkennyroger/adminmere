import "./bootstrap";
import "./components/toast";
// import Alpine from "alpinejs"; // Removed to avoid conflict with Livewire's Alpine
import intersect from "@alpinejs/intersect";
import ApexCharts from "apexcharts";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Calendar } from "@fullcalendar/core";

// Stores
import { initThemeStore } from "./theme";
import { initSidebarStore } from "./components/sidebar";
import { initChatStore } from "./components/chat";

// 1. Initialize & Globalize Alpine
// 1. Initialize & Globalize Alpine
// We use the alpine:init event to register stores on the Alpine instance that Livewire uses.
// This prevents "two Alpines" race conditions.

document.addEventListener("alpine:init", () => {
    // Register Plugins
    window.Alpine.plugin(intersect);

    // Register Stores
    initThemeStore();
    initSidebarStore();
    initChatStore();

    console.log("Alpine stores and plugins initialized for Livewire 3");
});

// 4. Global Libraries
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

// 5. Localization & Components
const Portuguese = {
    weekdays: {
        shorthand: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        longhand: [
            "Domingo",
            "Segunda-feira",
            "Terça-feira",
            "Quarta-feira",
            "Quinta-feira",
            "Sexta-feira",
            "Sábado",
        ],
    },
    months: {
        shorthand: [
            "Jan",
            "Fev",
            "Mar",
            "Abr",
            "Mai",
            "Jun",
            "Jul",
            "Ago",
            "Set",
            "Out",
            "Nov",
            "Dez",
        ],
        longhand: [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro",
        ],
    },
    rangeSeparator: " até ",
    time_24hr: true,
};
flatpickr.localize(Portuguese);

document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector("#goalChart")) {
        import("./components/goals-chart").then((m) => m.initGoalChart());
    }
    if (document.querySelector("#userGrowthChart")) {
        import("./components/user-growth-chart");
    }
    if (document.querySelector("#calendar")) {
        import("./components/calendar-init").then((m) => m.calendarInit());
    }
    import("./components/quill-editor").then((m) => m.initQuillEditor());
});
