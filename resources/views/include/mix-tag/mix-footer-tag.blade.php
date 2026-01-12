@include('include.toast')

@yield('above-script')
<!-- Sandy Plugins -->
<script src="{{ gs('assets/js/axios.min.js') }}" data-no-instant></script>
<!-- Jquery -->
<script src="{{ gs('assets/js/vendor/jquery/jquery.min.js') }}" data-no-instant></script>
<!-- Pickr -->
<script src="{{ gs('assets/js/vendor/pickr/pickr.min.js') }}"></script>
<!-- Pickr -->
<script src="{{ gs('assets/js/vendor/fontpicker/jquery.fontpicker.js') }}"></script>
<!-- Sandy Plugins -->
<script src="{{ gs('assets/js/sandy.plugins.js') }}" data-no-instant></script>
<!-- Sandy functions -->
<script src="{{ gs('assets/js/sandy.functions.js')  }}" data-no-instant></script>
<!-- Sandy scripts -->
<script src="{{ gs('assets/js/sandy.customs.js') }}" data-no-instant></script>
<!-- Sandy scripts -->
<script src="{{ gs('assets/js/sandy.jquery.js') }}"></script>
<!-- Sandy Plugins -->
<script src="{{ gs('assets/js/select2.min.js') }}" data-no-instant></script>
<!-- Custom page scripts -->
<script defer="" data-no-instant="" src="{{ gs('assets/js/alpine.min.js') }}"></script>
<!-- Custom page scripts -->

<script>
    
    $.fn.datepicker.language['en'] = {
        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        ],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: 'Today',
        clear: 'Clear',
        dateFormat: 'mm/dd/yyyy',
        timeFormat: 'hh:ii aa',
        firstDay: 1
    };
</script>

@yield('footerJS')