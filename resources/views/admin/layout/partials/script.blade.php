<script src="{{ asset('theme/js/app.js') }}"></script>
<script src="{{ asset('theme/js/common.js') }}"></script>
<script src="{{ asset('theme/js/charts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('theme/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('theme/js/toastr.min.js') }}"></script>
<script src="{{ asset('theme/js/my-custom.js') }}"></script>
<script src="{{ asset('theme/js/dropify/js/dropify.min.js') }}"></script>
<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Drag and drop file',
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });
</script>
@yield('script')
