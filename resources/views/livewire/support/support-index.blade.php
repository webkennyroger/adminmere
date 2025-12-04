<div>
    <x-common.page-breadcrumb pageTitle="Calendário" />

    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
        <article
            class="flex gap-5 rounded-xl border border-gray-200 bg-white p-4 shadow-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div
                class="bg-brand-500/10 text-brand-500 inline-flex h-14 w-14 items-center justify-center rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path
                        d="M4.95833 6.125C3.99183 6.125 3.20833 6.9085 3.20833 7.875V11.2998C4.69996 11.2998 5.9098 12.509 5.9098 14.0006C5.9098 15.4923 4.7006 16.7015 3.20897 16.7015L3.20833 20.125C3.20833 21.0915 3.99183 21.875 4.95833 21.875H23.0417C24.0082 21.875 24.7917 21.0915 24.7917 20.125V16.7015C23.3003 16.7011 22.0915 15.4921 22.0915 14.0006C22.0915 12.5092 23.3003 11.3001 24.7917 11.2998V7.875C24.7917 6.9085 24.0082 6.125 23.0417 6.125H4.95833Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-title-xs mb-1 font-semibold text-gray-800 dark:text-white/90">5,347</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total tickets</p>
            </div>
        </article>
        <article
            class="flex gap-5 rounded-xl border border-gray-200 bg-white p-4 shadow-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div
                class="bg-warning-500/10 text-warning-500 inline-flex h-14 w-14 items-center justify-center rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                    <path
                        d="M5.33333 4.66675H24M5.33333 23.3334L24 23.3334M21.6667 4.66675V7.0001C21.6667 10.8661 18.5327 14.0001 14.6667 14.0001M7.66666 4.66675V7.0001C7.66666 10.8661 10.8007 14.0001 14.6667 14.0001M14.6667 14.0001C18.5327 14.0001 21.6667 17.1341 21.6667 21.0001V23.3334M14.6667 14.0001C10.8007 14.0001 7.66666 17.1341 7.66666 21.0001L7.66666 23.3334"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-title-xs mb-1 font-semibold text-gray-800 dark:text-white/90">1,230
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Pending tickets
                </p>
            </div>
        </article>
        <article
            class="flex gap-5 rounded-xl border border-gray-200 bg-white p-4 shadow-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div
                class="bg-success-500/10 text-success-500 inline-flex h-14 w-14 items-center justify-center rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                    <path
                        d="M17.8062 11.6598L13.1257 16.3403L10.8605 14.0751M25.125 13.9999C25.125 19.96 20.2934 24.7916 14.3334 24.7916C8.37328 24.7916 3.54169 19.96 3.54169 13.9999C3.54169 8.03985 8.37328 3.20825 14.3334 3.20825C20.2934 3.20825 25.125 8.03985 25.125 13.9999Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-title-xs mb-1 font-semibold text-gray-800 dark:text-white/90">4,117
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Solved tickets
                </p>
            </div>
        </article>
    </div>
    <!-- Table -->
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-800">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Support Tickets
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Your most recent support tickets list
                </p>
            </div>
            <div class="flex gap-3.5">

                <div x-data="{
                selected: 'all',
                changeTab(tab) {
                    this.selected = tab;
                    $dispatch('change-tab', { tab: tab });
                }
            }" class="hidden h-11 items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 lg:inline-flex dark:bg-gray-900">

                    <button @click="changeTab('all'); $dispatch('change-tab', 'all')" :class="selected === 'all' ?
                        'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                        'text-gray-500 dark:text-gray-400'"
                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium hover:text-gray-900 dark:hover:text-white shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800">
                        All
                    </button>
                    <button @click="changeTab('solved'); $dispatch('change-tab', 'solved')" :class="selected === 'solved' ?
                        'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                        'text-gray-500 dark:text-gray-400'"
                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-gray-400">
                        Solved
                    </button>
                    <button @click="changeTab('pending'); $dispatch('change-tab', 'pending')" :class="selected === 'pending' ?
                        'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                        'text-gray-500 dark:text-gray-400'"
                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-gray-400">
                        Pending
                    </button>
                </div>

                <div class="hidden flex-col gap-3 sm:flex sm:flex-row sm:items-center">
                    <div class="relative">
                        <span class="absolute top-1/2 left-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                    fill=""></path>
                            </svg>
                        </span>

                        <input type="text" placeholder="Search..."
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[300px] dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    </div>

                    <div class="relative" x-data="{ showFilter: false }">
                        <button
                            class="shadow-theme-xs flex h-11 w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 sm:w-auto sm:min-w-[100px] dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                            @click="showFilter = !showFilter" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M14.6537 5.90414C14.6537 4.48433 13.5027 3.33331 12.0829 3.33331C10.6631 3.33331 9.51206 4.48433 9.51204 5.90415M14.6537 5.90414C14.6537 7.32398 13.5027 8.47498 12.0829 8.47498C10.663 8.47498 9.51204 7.32398 9.51204 5.90415M14.6537 5.90414L17.7087 5.90411M9.51204 5.90415L2.29199 5.90411M5.34694 14.0958C5.34694 12.676 6.49794 11.525 7.91777 11.525C9.33761 11.525 10.4886 12.676 10.4886 14.0958M5.34694 14.0958C5.34694 15.5156 6.49794 16.6666 7.91778 16.6666C9.33761 16.6666 10.4886 15.5156 10.4886 14.0958M5.34694 14.0958L2.29199 14.0958M10.4886 14.0958L17.7087 14.0958"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                            Filter
                        </button>
                        <div x-show="showFilter" @click.away="showFilter = false"
                            class="absolute right-0 z-10 mt-2 w-56 rounded-lg border border-gray-200 bg-white p-4 shadow-lg dark:border-gray-700 dark:bg-gray-800"
                            style="display: none;">
                            <div class="mb-5">
                                <label class="mb-2 block text-xs font-medium text-gray-700 dark:text-gray-300">
                                    Category
                                </label>
                                <input type="text"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    placeholder="Search category...">
                            </div>
                            <div class="mb-5">
                                <label class="mb-2 block text-xs font-medium text-gray-700 dark:text-gray-300">
                                    Company
                                </label>
                                <input type="text"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    placeholder="Search company...">
                            </div>
                            <button
                                class="bg-brand-500 hover:bg-brand-600 h-10 w-full rounded-lg px-3 py-2 text-sm font-medium text-white">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{
    selectAll: false,
    selected: [],
    selectedTab: 'all',
    tickets: [
        { id: '#323534', name: 'Lindsey Curtis', email: 'demoemail@gmail.com', subject: 'Issue with Dashboard Login Access', date: '12 Feb, 2027', status: 'Solved', statusClass: 'bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500' },
        { id: '#323535', name: 'Kaiya George', email: 'demoemail@gmail.com', subject: 'Billing Information Not Updating Properly', date: '13 Mar, 2027', status: 'Pending', statusClass: 'bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500' },
        { id: '#323536', name: 'Zain Geidt', email: 'demoemail@gmail.com', subject: 'Bug Found in Dark Mode Layout', date: '19 Mar, 2027', status: 'Pending', statusClass: 'bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500' },
        { id: '#323537', name: 'Abram Schleifer', email: 'demoemail@gmail.com', subject: 'Request to Add New Integration Feature', date: '25 Apr, 2027', status: 'Solved', statusClass: 'bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500' },
        { id: '#323538', name: 'Mia Chen', email: 'mia.chen@email.com', subject: 'Unable to Reset Password', date: '28 Apr, 2027', status: 'Pending', statusClass: 'bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500' },
        { id: '#323539', name: 'John Doe', email: 'john.doe@email.com', subject: 'Feature Request: Dark Mode', date: '30 Apr, 2027', status: 'Solved', statusClass: 'bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500' },
        { id: '#323540', name: 'Jane Smith', email: 'jane.smith@email.com', subject: 'Error 500 on Dashboard', date: '01 May, 2027', status: 'Pending', statusClass: 'bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500' },
        { id: '#323541', name: 'Carlos Ruiz', email: 'carlos.ruiz@email.com', subject: 'Cannot Download Invoice', date: '02 May, 2027', status: 'Solved', statusClass: 'bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500' },
        { id: '#323542', name: 'Emily Clark', email: 'emily.clark@email.com', subject: 'UI Bug in Mobile View', date: '03 May, 2027', status: 'Pending', statusClass: 'bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500' },
        { id: '#323543', name: 'Liam Wong', email: 'liam.wong@email.com', subject: 'Account Locked', date: '04 May, 2027', status: 'Solved', statusClass: 'bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500' },
        { id: '#323544', name: 'Sophia Patel', email: 'sophia.patel@email.com', subject: 'Integration Not Working', date: '05 May, 2027', status: 'Pending', statusClass: 'bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500' },
        { id: '#323545', name: 'Noah Kim', email: 'noah.kim@email.com', subject: 'Request for API Access', date: '06 May, 2027', status: 'Solved', statusClass: 'bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500' }
    ],
    currentPage: 1,
    perPage: 10,
    sortBy: '',
    sortAsc: true,

    get filteredTickets() {
        if (this.selectedTab === 'all') {
            return this.tickets;
        }
        // Capitalize first letter to match status format ('Solved', 'Pending')
        const tabFilter = this.selectedTab.charAt(0).toUpperCase() + this.selectedTab.slice(1).toLowerCase();
        return this.tickets.filter(ticket =&gt; ticket.status === tabFilter);
    },

    sortTickets(field) {
        if (this.sortBy === field) {
            this.sortAsc = !this.sortAsc;
        } else {
            this.sortBy = field;
            this.sortAsc = true;
        }
        this.tickets.sort((a, b) =&gt; {
            let valA = a[field];
            let valB = b[field];
            if (field === 'date') {
                const parse = v =&gt; new Date(v.split(',').length &gt; 1 ? v : v.replace(/(\d{2}) (\w+), (\d{4})/, '$2 $1, $3'));
                valA = parse(valA);
                valB = parse(valB);
            } else {
                valA = valA.toString().toLowerCase();
                valB = valB.toString().toLowerCase();
            }
            if (valA &lt; valB) return this.sortAsc ? -1 : 1;
            if (valA &gt; valB) return this.sortAsc ? 1 : -1;
            return 0;
        });
    },

    get totalPages() {
        return Math.ceil(this.filteredTickets.length / this.perPage);
    },

    get paginatedTickets() {
        const start = (this.currentPage - 1) * this.perPage;
        return this.filteredTickets.slice(start, start + this.perPage);
    },

    prevPage() {
        if (this.currentPage &gt; 1) this.currentPage--;
    },

    nextPage() {
        if (this.currentPage &lt; this.totalPages) this.currentPage++;
    },

    goToPage(page) {
        if (page &gt;= 1 &amp;&amp; page &lt;= this.totalPages) this.currentPage = page;
    },

    changeTab(tab) {
        this.selectedTab = tab;
        this.currentPage = 1;
        this.selectAll = false;
        this.selected = [];
    },

    toggleAll() {
        if (this.selectAll) {
            this.selected = this.paginatedTickets.map(t =&gt; t.id);
        } else {
            this.selected = [];
        }
    },

    toggleOne(id) {
        if (this.selected.includes(id)) {
            this.selected = this.selected.filter(i =&gt; i !== id);
        } else {
            this.selected.push(id);
        }
        this.selectAll = this.selected.length === this.paginatedTickets.length;
    }
}" @change-tab.window="changeTab($event.detail)">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-800">
                            <th class="px-4 py-3 whitespace-nowrap">
                                <div class="flex w-full cursor-pointer items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <span class="relative">
                                                <input type="checkbox" class="sr-only" x-model="selectAll"
                                                    @change="toggleAll">
                                                <span :class="selectAll ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                    <span :class="selectAll ? '' : 'opacity-0'" class="opacity-0">
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                                stroke-width="1.6666" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                        <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                            Ticket ID
                                        </p>
                                    </div>
                                </div>
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-700 dark:text-gray-400">
                                <div class="flex cursor-pointer items-center justify-between gap-3"
                                    @click="sortTickets('name')">
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                        Requested By
                                    </p>
                                    <span class="flex flex-col gap-0.5">
                                        <svg :class="sortBy === 'name' &amp;&amp; sortAsc ? 'text-gray-500 dark:text-gray-300' :
                                    'text-gray-300 dark:text-gray-400'" width="8" height="5" viewBox="0 0 8 5"
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="text-gray-300 dark:text-gray-400">
                                            <path
                                                d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <svg :class="sortBy === 'name' &amp;&amp; !sortAsc ? 'text-gray-500 dark:text-gray-300' :
                                    'text-gray-300 dark:text-gray-400'" width="8" height="5" viewBox="0 0 8 5"
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="text-gray-300 dark:text-gray-400">
                                            <path
                                                d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </div>
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-700 dark:text-gray-400">
                                Subject
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-700 dark:text-gray-400">
                                <div class="flex cursor-pointer items-center justify-between gap-3"
                                    @click="sortTickets('date')">
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                        Create Date
                                    </p>
                                    <span class="flex flex-col gap-0.5">
                                        <svg :class="sortBy === 'date' &amp;&amp; sortAsc ? 'text-gray-500 dark:text-gray-300' :
                                    'text-gray-300 dark:text-gray-400'" width="8" height="5" viewBox="0 0 8 5"
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="text-gray-300 dark:text-gray-400">
                                            <path
                                                d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <svg :class="sortBy === 'date' &amp;&amp; !sortAsc ? 'text-gray-500 dark:text-gray-300' :
                                    'text-gray-300  dark:text-gray-400'" width="8" height="5" viewBox="0 0 8 5"
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="text-gray-300 dark:text-gray-400">
                                            <path
                                                d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </div>
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-700 dark:text-gray-400">
                                Status
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-700 dark:text-gray-400">
                                <div class="relative">
                                    <span class="sr-only">Action</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        <template x-for="ticket in paginatedTickets" :key="ticket.id">
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <span class="relative">
                                                <input type="checkbox" class="sr-only" :value="ticket.id"
                                                    :checked="selected.includes(ticket.id)"
                                                    @change="toggleOne(ticket.id)">
                                                <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px]">
                                                    <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'">
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                                stroke-width="1.6666" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                        <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                            x-text="ticket.id"></p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div>
                                        <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                            x-text="ticket.name"></span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject"></p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date"></p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span
                                        :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                        x-text="ticket.status"></span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="relative flex justify-center">
                                        <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                            <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                                <button type="button" id="options-menu" aria-haspopup="true"
                                                    aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                    <svg class="fill-current" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="z-50 fixed" x-ref="content">
                                                <div x-show="isOpen" x-cloak=""
                                                    class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40">
                                                    <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                        aria-labelledby="options-menu">
                                                        <a href="#"
                                                            class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                            role="menuitem">
                                                            View More
                                                        </a>
                                                        <a href="#"
                                                            class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                            role="menuitem">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323534">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323534</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Lindsey Curtis</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        demoemail@gmail.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Issue
                                    with Dashboard Login Access</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">12 Feb,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Solved</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, -2px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323535">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323535</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Kaiya George</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        demoemail@gmail.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Billing
                                    Information Not Updating Properly</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">13 Mar,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Pending</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 67px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323536">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323536</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Zain Geidt</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        demoemail@gmail.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Bug
                                    Found in Dark Mode Layout</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">19 Mar,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Pending</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 136px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323537">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323537</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Abram Schleifer</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        demoemail@gmail.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Request
                                    to Add New Integration Feature</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">25 Apr,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Solved</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 205px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323538">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323538</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Mia Chen</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        mia.chen@email.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Unable
                                    to Reset Password</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">28 Apr,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Pending</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 274px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323539">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323539</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">John Doe</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        john.doe@email.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Feature
                                    Request: Dark Mode</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">30 Apr,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Solved</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 343px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323540">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323540</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Jane Smith</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        jane.smith@email.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Error
                                    500 on Dashboard</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">01 May,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Pending</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 412px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323541">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323541</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Carlos Ruiz</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        carlos.ruiz@email.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Cannot
                                    Download Invoice</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">02 May,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Solved</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 481px);"
                                            data-popper-placement="top-end" data-popper-reference-hidden=""
                                            data-popper-escaped="">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323542">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323542</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Emily Clark</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        emily.clark@email.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">UI Bug
                                    in Mobile View</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">03 May,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Pending</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 550px);"
                                            data-popper-reference-hidden="" data-popper-escaped=""
                                            data-popper-placement="top-end">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <span class="relative">
                                            <input type="checkbox" class="sr-only" :value="ticket.id"
                                                :checked="selected.includes(ticket.id)"
                                                @change="toggleOne(ticket.id)" value="#323543">
                                            <span :class="selected.includes(ticket.id) ? 'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                <span :class="selected.includes(ticket.id) ? '' : 'opacity-0'"
                                                    class="opacity-0">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                            stroke-width="1.6666" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400"
                                        x-text="ticket.id">#323543</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90"
                                        x-text="ticket.name">Liam Wong</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="ticket.email">
                                        liam.wong@email.com</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.subject">Account
                                    Locked</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date">04 May,
                                    2027</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="ticket.statusClass + ' text-theme-xs rounded-full px-2 py-0.5 font-medium'"
                                    x-text="ticket.status"
                                    class="bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500 text-theme-xs rounded-full px-2 py-0.5 font-medium">Solved</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <div x-data="{
isOpen: false,
popperInstance: null,
init() {
    this.$nextTick(() =&gt; {
        this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
            placement: 'bottom-end',
            strategy: 'fixed',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
            ],
        });
    });
},
toggle() {
    this.isOpen = !this.isOpen;
    if (this.popperInstance) {
        this.popperInstance.update();
    }
}
}" @click.away="isOpen = false">
                                        <div @click="toggle()" x-ref="button" class="cursor-pointer">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="z-50 fixed" x-ref="content"
                                            style="position: fixed; inset: auto 0px 0px auto; margin: 0px; transform: translate(-102px, 619px);"
                                            data-popper-reference-hidden="" data-popper-escaped=""
                                            data-popper-placement="top-end">
                                            <div x-show="isOpen"
                                                class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40"
                                                style="display: none;">
                                                <div class="space-y-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="options-menu">
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        View More
                                                    </a>
                                                    <a href="#"
                                                        class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                        role="menuitem">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div
                class="flex flex-col items-center justify-between border-t border-gray-200 px-5 py-4 sm:flex-row dark:border-gray-800">
                <div class="pb-3 sm:pb-0">
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="text-gray-800 dark:text-white/90" x-text="((currentPage-1)*perPage+1)">1</span>
                        to
                        <span class="text-gray-800 dark:text-white/90"
                            x-text="Math.min(currentPage*perPage, tickets.length)">10</span>
                        of
                        <span class="text-gray-800 dark:text-white/90" x-text="tickets.length">12</span>
                    </span>
                </div>
                <div
                    class="flex w-full items-center justify-between gap-2 rounded-lg bg-gray-50 p-4 sm:w-auto sm:justify-normal sm:bg-transparent sm:p-0 dark:bg-white/[0.03] dark:sm:bg-transparent">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="shadow-theme-xs flex items-center gap-2 rounded-lg border border-gray-300 bg-white p-2 text-gray-700 hover:bg-gray-50 hover:text-gray-800 disabled:cursor-not-allowed disabled:opacity-50 sm:p-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                        disabled="disabled">
                        <span>
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.58203 9.99868C2.58174 10.1909 2.6549 10.3833 2.80152 10.53L7.79818 15.5301C8.09097 15.8231 8.56584 15.8233 8.85883 15.5305C9.15183 15.2377 9.152 14.7629 8.85921 14.4699L5.13911 10.7472L16.6665 10.7472C17.0807 10.7472 17.4165 10.4114 17.4165 9.99715C17.4165 9.58294 17.0807 9.24715 16.6665 9.24715L5.14456 9.24715L8.85919 5.53016C9.15199 5.23717 9.15184 4.7623 8.85885 4.4695C8.56587 4.1767 8.09099 4.17685 7.79819 4.46984L2.84069 9.43049C2.68224 9.568 2.58203 9.77087 2.58203 9.99715C2.58203 9.99766 2.58203 9.99817 2.58203 9.99868Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <span class="block text-sm font-medium text-gray-700 sm:hidden dark:text-gray-400">
                        Page <span x-text="currentPage">1</span> of
                        <span x-text="totalPages">2</span>
                    </span>
                    <ul class="hidden items-center gap-0.5 sm:flex">
                        <template x-for="page in totalPages" :key="page">
                            <li>
                                <a href="#" @click.prevent="goToPage(page)"
                                    :class="currentPage === page ?
                                'bg-brand-500 hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-white hover:text-white' :
                                'hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:text-white dark:text-gray-400 dark:hover:text-white'">
                                    <span x-text="page"></span>
                                </a>
                            </li>
                        </template>
                        <li>
                            <a href="#" @click.prevent="goToPage(page)"
                                :class="currentPage === page ?
                                'bg-brand-500 hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-white hover:text-white' :
                                'hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:text-white dark:text-gray-400 dark:hover:text-white'"
                                class="bg-brand-500 hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-white hover:text-white">
                                <span x-text="page">1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" @click.prevent="goToPage(page)"
                                :class="currentPage === page ?
                                'bg-brand-500 hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-white hover:text-white' :
                                'hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:text-white dark:text-gray-400 dark:hover:text-white'"
                                class="hover:bg-brand-500 flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:text-white dark:text-gray-400 dark:hover:text-white">
                                <span x-text="page">2</span>
                            </a>
                        </li>
                    </ul>
                    <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="shadow-theme-xs flex items-center gap-2 rounded-lg border border-gray-300 bg-white p-2 text-gray-700 hover:bg-gray-50 hover:text-gray-800 disabled:cursor-not-allowed disabled:opacity-50 sm:p-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                        <span>
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.4165 9.9986C17.4168 10.1909 17.3437 10.3832 17.197 10.53L12.2004 15.5301C11.9076 15.8231 11.4327 15.8233 11.1397 15.5305C10.8467 15.2377 10.8465 14.7629 11.1393 14.4699L14.8594 10.7472L3.33203 10.7472C2.91782 10.7472 2.58203 10.4114 2.58203 9.99715C2.58203 9.58294 2.91782 9.24715 3.33203 9.24715L14.854 9.24715L11.1393 5.53016C10.8465 5.23717 10.8467 4.7623 11.1397 4.4695C11.4327 4.1767 11.9075 4.17685 12.2003 4.46984L17.1578 9.43049C17.3163 9.568 17.4165 9.77087 17.4165 9.99715C17.4165 9.99763 17.4165 9.99812 17.4165 9.9986Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>