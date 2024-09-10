$(document).ready(function () {
    $('#loginHandler').on('submit', function (e) {
        e.preventDefault();
        let email = $('#email').val();
        let password = $('#password').val();
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/loginHandler',
            data: {
                email: email,
                password: password
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                console.log(data)

                console.log(data.success);

                if (data.success) {
                    console.log('haha lol');
                    $('#mainContainer').html('');
                    // convert object to array
                    let company = data.message;
                    for (let key in company) {
                        if (company.hasOwnProperty(key)) {
                            let value = company[key];
                            console.log(key);
                            console.log(value);
                            $('#mainContainer').append(`
                            <h1>${key}</h1>
                            <button id="companySelectedUser" class="companySelectedUser" value="${value}">Choose company</button>
                            <br><br>
                            `);
                        }
                    }
                }
            }
        });
    });

    $('#registerCompany').on('submit', function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let domain = $('#domain').val();
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        console.log(name, domain, csrfToken);

        $.ajax({
            type: 'POST',
            url: '/registerCompanyHandler',
            data: {
                name: name,
                domain: domain
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('click', '#companySelectedUser', function () {
        let company = $(this).val();
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/companySelectedUser',
            data: {
                company: company
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                console.log(data);
            }
        });
    });
});
