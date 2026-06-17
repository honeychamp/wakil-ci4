<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Schedule &amp; Calendar - Brocelle Client Portal</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0b1f3a;
            --secondary-color: #c5a859;
            --text-dark: #333;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Georgia', serif;
            color: var(--text-dark);
        }
        .header-custom {
            background-color: var(--primary-color);
            border-bottom: 3px solid var(--secondary-color);
            color: white;
        }
        .navbar-brand-portal {
            color: var(--secondary-color) !important;
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            font-size: 1.4rem;
        }
        .card-custom {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border-radius: 8px;
        }
        .btn-gold {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: bold;
            border: none;
        }
        .btn-gold:hover {
            background-color: #dcb865;
            color: var(--primary-color);
        }
        .calendar-day-cell {
            width: 14.285%;
            min-height: 100px;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            position: relative;
            background: #fff;
            padding: 6px;
        }
        .calendar-day-cell.other-month {
            background-color: #f8f9fa;
            color: #adb5bd;
        }
        .calendar-day-cell.today-cell {
            background-color: #f1f8ff;
        }
        .calendar-day-cell .day-num {
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 6px;
            display: block;
        }
        .calendar-day-cell.today-cell .day-num {
            color: var(--secondary-color);
            display: inline-block;
            border-bottom: 2px solid var(--secondary-color);
        }
        .calendar-event-item {
            display: block;
            font-size: 0.72rem;
            padding: 3px 6px;
            margin-bottom: 4px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: 0.15s ease-in-out;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .calendar-event-item:hover {
            transform: scale(1.02);
            opacity: 0.9;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark header-custom py-3">
        <div class="container">
            <a class="navbar-brand navbar-brand-portal" href="<?= base_url('client/dashboard') ?>">
                <i class="fa-solid fa-scale-balanced me-2"></i>Brocelle Client Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clientNavbar" aria-controls="clientNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="clientNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="<?= base_url('client/dashboard') ?>"><i class="fa-solid fa-briefcase me-1"></i> Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="<?= base_url('client/invoices') ?>"><i class="fa-solid fa-file-invoice-dollar me-1"></i> Invoices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-white" href="<?= base_url('client/calendar') ?>"><i class="fa-solid fa-calendar-days me-1"></i> Calendar</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="d-none d-md-inline text-white-50 small">Logged in: <strong><?= session()->get('client_name') ?></strong></span>
                    <a href="<?= base_url('client/logout') ?>" class="btn btn-sm btn-outline-danger px-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <span class="text-muted small uppercase fw-bold">Schedule Tracker</span>
                <h2 class="fw-bold" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">My Cases Calendar</h2>
                <div style="width: 50px; height: 3px; background-color: var(--secondary-color); margin-top: 5px;"></div>
            </div>
        </div>

        <div class="card card-custom border-0 shadow-sm mb-4 bg-white">
            <div class="card-body p-4">
                <!-- Calendar Controls -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <button class="btn btn-outline-dark me-1" id="btnPrevMonth"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="btn btn-outline-dark" id="btnNextMonth"><i class="fa-solid fa-chevron-right"></i></button>
                        <button class="btn btn-dark ms-2 fw-semibold" id="btnToday">Today</button>
                    </div>
                    <h3 class="fw-bold mb-0 text-capitalize" id="calendarTitle" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">June 2026</h3>
                    <div class="d-flex gap-3 text-muted small">
                        <span><i class="fa-solid fa-circle text-danger me-1"></i> Hearings</span>
                        <span><i class="fa-solid fa-circle text-warning me-1"></i> Invoice Deadlines</span>
                    </div>
                </div>

                <!-- Weekday Headers -->
                <div class="row g-0 text-center fw-bold border-bottom pb-2 mb-2 text-uppercase text-muted" style="font-size: 0.85rem;">
                    <div class="col" style="width: 14.28%;">Sun</div>
                    <div class="col" style="width: 14.28%;">Mon</div>
                    <div class="col" style="width: 14.28%;">Tue</div>
                    <div class="col" style="width: 14.28%;">Wed</div>
                    <div class="col" style="width: 14.28%;">Thu</div>
                    <div class="col" style="width: 14.28%;">Fri</div>
                    <div class="col" style="width: 14.28%;">Sat</div>
                </div>

                <!-- Days Grid -->
                <div class="row g-0 border-start border-top" id="calendarGrid" style="min-height: 500px;">
                    <!-- Rendered by JS -->
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted small py-4 mt-5 border-top">
        &copy; <?= date('Y') ?> Brocelle Law Firm. All rights reserved. Secure Portal Interface.
    </footer>

    <script>
        const events = <?= $eventsJson ?>;
        
        let currentDate = new Date();
        
        // Parse event dates
        events.forEach(ev => {
            ev.parsedDate = new Date(ev.start + 'T00:00:00');
        });

        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Title
            document.getElementById('calendarTitle').textContent = `${monthNames[month]} ${year}`;

            // Grid
            const grid = document.getElementById('calendarGrid');
            grid.innerHTML = '';

            // First day of month
            const firstDayIndex = new Date(year, month, 1).getDay();

            // Last day of month
            const lastDay = new Date(year, month + 1, 0).getDate();

            // Last day of previous month
            const prevLastDay = new Date(year, month, 0).getDate();

            // Render previous month's trailing days
            for (let i = firstDayIndex; i > 0; i--) {
                const dayNum = prevLastDay - i + 1;
                const cellDate = new Date(year, month - 1, dayNum);
                createDayCell(dayNum, true, cellDate, grid);
            }

            // Render current month days
            const today = new Date();
            for (let i = 1; i <= lastDay; i++) {
                const cellDate = new Date(year, month, i);
                const isToday = cellDate.getDate() === today.getDate() && 
                                cellDate.getMonth() === today.getMonth() && 
                                cellDate.getFullYear() === today.getFullYear();
                createDayCell(i, false, cellDate, grid, isToday);
            }

            // Render next month's leading days
            const totalCells = grid.children.length;
            const remainingCells = (totalCells <= 35) ? 35 - totalCells : 42 - totalCells;
            for (let i = 1; i <= remainingCells; i++) {
                const cellDate = new Date(year, month + 1, i);
                createDayCell(i, true, cellDate, grid);
            }
        }

        function createDayCell(dayNum, isOtherMonth, cellDate, container, isToday = false) {
            const cell = document.createElement('div');
            cell.className = 'calendar-day-cell';
            if (isOtherMonth) cell.classList.add('other-month');
            if (isToday) cell.classList.add('today-cell');

            const numSpan = document.createElement('span');
            numSpan.className = 'day-num';
            numSpan.textContent = dayNum;
            cell.appendChild(numSpan);

            // Filter events for this cell date
            const cellEvents = events.filter(ev => {
                return ev.parsedDate.getDate() === cellDate.getDate() &&
                       ev.parsedDate.getMonth() === cellDate.getMonth() &&
                       ev.parsedDate.getFullYear() === cellDate.getFullYear();
            });

            cellEvents.forEach(ev => {
                const evLink = document.createElement('a');
                evLink.className = 'calendar-event-item';
                evLink.style.backgroundColor = ev.color;
                evLink.href = ev.url;
                evLink.title = ev.title;
                evLink.textContent = ev.title;
                cell.appendChild(evLink);
            });

            container.appendChild(cell);
        }

        document.getElementById('btnPrevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('btnNextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        document.getElementById('btnToday').addEventListener('click', () => {
            currentDate = new Date();
            renderCalendar();
        });

        // Initial load
        renderCalendar();
    </script>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
