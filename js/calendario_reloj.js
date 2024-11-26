//CALENDARIO
document.addEventListener('DOMContentLoaded', () => {

    const calendar = document.getElementById('calendar');
    const calendarMonthYear = document.getElementById('calendar-month-year');
    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    const todayDate = today.getDate();

    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const holidays = {
        '1-1': 'Año Nuevo',
        '25-12': 'Navidad'
    };

    const events = {};

    function generateCalendar(month, year) {
        calendar.innerHTML = '';
        calendarMonthYear.textContent = `${monthNames[month]} ${year}`;

        const firstDay = (new Date(year, month).getDay() + 6) % 7; // Ajustar para que empiece en lunes
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const daysOfWeek = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];

        for (let day of daysOfWeek) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day', 'day-header');
            dayElement.textContent = day;
            calendar.appendChild(dayElement);
        }

        for (let i = 0; i < firstDay; i++) {
            const emptyElement = document.createElement('div');
            emptyElement.classList.add('day');
            calendar.appendChild(emptyElement);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dayElement = document.createElement('div');
            dayElement.classList.add('day');
            dayElement.textContent = day;

            const holidayKey = `${day}-${month + 1}`;
            if (holidays[holidayKey]) {
                dayElement.classList.add('holiday');
                dayElement.title = holidays[holidayKey];
            }

            if (events[date.toDateString()]) {
                dayElement.classList.add('event');
                dayElement.title = events[date.toDateString()];
            }

            if (day === todayDate && month === today.getMonth() && year === today.getFullYear()) {
                dayElement.classList.add('today');
                dayElement.title = "Hoy";
            }

            calendar.appendChild(dayElement);
        }
    }

    function addEvent(date, description) {
        events[date.toDateString()] = description;
        generateCalendar(currentMonth, currentYear);
    }

    generateCalendar(currentMonth, currentYear);

    // Para agregar un evento manualmente:
    // addEvent(new Date(currentYear, currentMonth, 14), 'Evento Importante');


    //RELOJ
    function actualizarReloj() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        
        let saludo;
        if (hours < 12) {
            saludo = 'Buenos días';
        } else if (hours < 19) {
            saludo = 'Buenas tardes';
        } else {
            saludo = 'Buenas noches';
        }

        const ampm = hours >= 12 ? 'pm' : 'am';
        const formattedHours = hours % 12 || 12;
        const relojText = `${formattedHours}:${minutes} ${ampm}`;

        document.getElementById('saludo').textContent = `${saludo}, son las ${relojText}.`;
    }

    setInterval(actualizarReloj, 1000);
    actualizarReloj(); // Llamar inmediatamente para mostrar el reloj sin esperar 1 segundo
});
