<script>
    const FilesBasePath  = "{{ getFileBasePath() }}";
    const locale          = "{{ getLocale() }}";
    const lightboxPath    = "{{ asset('dashboard-assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}";
</script>
<script src="{{asset('dashboard-assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('dashboard-assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('js/translations.js')}}"></script>
<script src="{{asset('js/dashboard/global_scripts.js')}}"></script>
@stack('scripts')

{{-- loading div --}}
{{--<script>--}}
{{--    $(window).on('load', function() {--}}
{{--        setTimeout( () => $("#loading-div").hide() , 1000);--}}
{{--    });--}}
{{--</script>--}}
{{-- loading div --}}

{{-- firebase push notifications--}}
{{--<script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-app.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-messaging.js"></script>--}}
{{--<script>--}}

{{--    $(document).ready( () => {--}}

{{--        try{--}}

{{--            const firebaseConfig = {--}}
{{--                apiKey: "AIzaSyD3ZpRJXdtaE6MWMr5fUaf0vKeN7Fxr9lA",--}}
{{--                authDomain: "webstdy-e-commerce.firebaseapp.com",--}}
{{--                projectId: "webstdy-e-commerce",--}}
{{--                storageBucket: "webstdy-e-commerce.appspot.com",--}}
{{--                messagingSenderId: "597742507713",--}}
{{--                appId: "1:597742507713:web:ea98c4aa2478d7764be640",--}}
{{--                measurementId: "G-WV8JPJCMRK"--}}
{{--            };--}}

{{--            // Initialize Firebase--}}
{{--            firebase.initializeApp(firebaseConfig);--}}
{{--            let messaging = firebase.messaging();--}}

{{--            initFirebaseMessagingRegistration();--}}
{{--            onPushing();--}}

{{--        }catch (error) {--}}
{{--            console.log(error)--}}
{{--        }--}}

{{--    })--}}

{{--    const onPushing = () => {--}}

{{--    messaging.onMessage( payload => {--}}

{{--            const data        = payload.data;--}}
{{--            const noteTitle   = payload.notification.title;--}}
{{--            const noteOptions = { icon: payload.notification.icon };--}}

{{--            /** append notification **/--}}
{{--            $("#notification-items-div").prepend(`--}}
{{--                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom notification-item">--}}
{{--                            <!--begin::Symbol-->--}}
{{--                        <div class="symbol symbol-40 symbol-light-primary mr-5">--}}
{{--                            <span class="symbol-label">--}}
{{--                              <i class="${data['gcm.notification.alert_icon']} text-${data['gcm.notification.class']} icon-lg"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <!--end::Symbol-->--}}
{{--                        <!--begin::Text-->--}}
{{--                        <div class="d-flex flex-column font-weight-bold">--}}
{{--                            <a href="/dashboard/notifications/${data['gcm.notification.id']}/mark_as_read" class="text-dark text-hover-primary mb-1 font-size-lg">${locator.__(data['gcm.notification.alert_title'])}</a>--}}
{{--                            <span class="text-muted">${data['gcm.notification.date']}</span>--}}
{{--                        </div>--}}
{{--                        <!--end::Text-->--}}
{{--                    </div>--}}
{{--            `);--}}

{{--            /** increment counter **/--}}
{{--            let notificationCounter = $("#notification-counter");--}}

{{--            if (!notificationCounter.length){--}}
{{--                $("#notification-bell").prepend(`--}}
{{--                    <span class="label label-sm label-light-danger label-rounded font-weight-bolder position-absolute top-0 right-0 mt-1 mr-1" id="notification-counter">1</span>--}}
{{--                    `);--}}
{{--            }else--}}
{{--                notificationCounter.text(parseInt(notificationCounter.text()) + 1);--}}

{{--            /** hide notification alert **/--}}
{{--            $("#no_notifications").hide();--}}

{{--            /** play notification sound **/--}}
{{--            $("#notificationSound").trigger('play');--}}


{{--            new Notification(noteTitle, noteOptions);--}}

{{--        });--}}
{{--    }--}}

{{--    const initFirebaseMessagingRegistration = () => {--}}

{{--    messaging--}}
{{--        .requestPermission()--}}
{{--        .then( () => messaging.getToken() )--}}
{{--        .then((token) => {--}}

{{--                if ( "{{ auth()->user()->device_token }}" !== token )--}}
{{--                {--}}
{{--                    $.ajax({--}}
{{--                        url: '{{ route("dashboard.save-token") }}',--}}
{{--                        type: 'POST',--}}
{{--                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },--}}
{{--                        data: { token },--}}
{{--                        dataType: 'JSON',--}}
{{--                        success: function (response) {--}}
{{--                            console.log('Token saved successfully.');--}}
{{--                        },--}}
{{--                        error: function (err) {--}}
{{--                            console.log('User Chat Token Error'+ err);--}}
{{--                        },--}}
{{--                    });--}}
{{--                }--}}

{{--        }).catch( err => console.log('User Chat Token Error'+ err) );--}}

{{--    }--}}

{{--</script>--}}
{{-- firebase push notifications--}}
