$(document).ready(function () {
    if (siteConfig.logged) {
        setInterval(function () {
            $.get('/api/notification')
                .then(function (notifications) {
                    var popover = $('.notification-popover');

                    popover.on('shown.bs.popover', function () {
                        setTimeout(function () {
                            popover.popover('hide');
                        }, 5000);
                    });

                    $.each(notifications, function (index, notification) {
                        popover.popover({
                            placement: 'bottom',
                            html: true,
                            content: notification.message,
                            title: notification.subject
                        }).popover('show');
                    });
                });
        }, 5000);
    }
});