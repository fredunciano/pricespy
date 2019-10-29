<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#country').select2({
            "language": {
                "noResults": function(){
                    return "@t('no_result_found')";
                }
            }
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .password .short {
        font-weight: bold;
        color: #ff4d6a;
    }

    .password .weak {
        font-weight: bold;
        color: #ff6a4d;
    }

    .password .good {
        font-weight: bold;
        color: #10b7b0;
    }

    .password .strong {
        font-weight: bold;
        color: #6cbd8f;
    }
</style>
<script>
    $(document).ready(function () {

        let password = $('#password');

        password.keyup(function () {
            $('#result').html(checkStrength(password.val()))
        })

        $('#password, #password_confirmation').keyup(checkPasswordMatch);

        function checkStrength(password) {
            //initial strength
            var strength = 0

            let result = $('#result');

            //if the password length is less than 6, return message.
            if (password.length < 5) {
                result.removeAttr('class')
                result.addClass('short')
                return '{{ t('Too short') }}'
            }

            //length is ok, lets continue.

            //if length is 8 characters or more, increase strength value
            if (password.length > 5) strength += 1
            //if password contains both lower and uppercase characters, increase strength value
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
            //if it has numbers and characters, increase strength value
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
            //if it has one special character, increase strength value
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
            //if it has two special characters, increase strength value
            if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
            //now we have calculated strength value, we can return messages

            //if value is less than 2
            result.removeAttr('class')
            if (strength < 2) {
                result.addClass('weak')
                return '{{ t('Weak') }}'
            } else if (strength === 2) {
                result.addClass('good')
                return '{{ t('Good') }}'
            } else {
                result.addClass('strong')
                return '{{ t('Strong') }}'
            }
        }

        function checkPasswordMatch() {
            let password = $('#password').val();
            let confirmPassword = $('#password_confirmation').val();

            if (password.length === 0 || confirmPassword.length === 0) {
                $("#passwordMatch").hide();
                return false
            }

            if (password != confirmPassword)
                $("#passwordMatch").show().removeAttr('class').addClass('weak').html("{{ t('Please confirm password.') }}");
            else
                $("#passwordMatch").show().removeAttr('class').addClass('good').html("{{ t('Passwords matched.') }}");
        }
    });

    $(document).ready(function () {
        adjustImage();
    });

    $(window).resize(function () {
        adjustImage();
    });

    function adjustImage() {
        let image = '@php echo auth()->user()->avatar ? storage()->url(auth()->user()->avatar) : asset('img/user.png') @endphp';
        if ($(window).width() <= 600) {
            image = image === '{{ asset('img/user.png') }}' ? '{{ asset('img/user-responsive.png') }}' : image;
            $('#image').attr('src', image);
        } else {
            $('#image').attr('src', image);
        }

    }
    window.isSubmitting = false;
</script>