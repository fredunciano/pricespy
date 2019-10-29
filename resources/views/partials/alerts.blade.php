@if (session('success'))
    <div id="alert-success" data-title="@t('success')" hidden>
        @tl(session('success'))
    </div>
@endif
@if (session('error'))
    <div id="alert-error" data-title="@t('error')" hidden>
        @tl(session('error'))
    </div>
@endif
@if (session('info'))
    <div id="alert-info" data-title="@t('info')" hidden>
        @tl(session('info'))
    </div>
@endif
@if (session('warning'))
    <div id="alert-warning" data-title="@t('warning')" hidden>
        @tl(session('warning'))
    </div>
@endif

{{--<div id="alertPopUp" class="modal fade" role="dialog">--}}
    {{--<div class="modal-dialog custom-modal-width">--}}

        {{--<!-- Modal content-->--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Are You sure</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<div class="row">--}}
                    {{--Achtung, Ihre Daten wurden nicht gesichert. Wenn Sie diese Seite jetzt verlassen gehen Ihre Daten unwiderruflich verloren!--}}
                {{--</div>--}}

            {{--</div>--}}
            {{--<div class="modal-footer">--}}

                {{--<button type="button" class="btn btn-success-custom" style="display: inline-block">--}}
                    {{--NO--}}
                {{--</button>--}}

                {{--<button type="button" class="btn btn-success-custom" style="display: inline-block">--}}
                    {{--YES--}}
                {{--</button>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}
{{--</div>--}}