<div class="modal active-modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">تأكيد التفعيل</p>
            <button class="delete close-modal" aria-label="close"></button>
        </header>
        <form class="delete-form" method="POST" action="" accept-charset="UTF-8">
            <input name="_method" type="hidden" value="PATCH">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <section class="modal-card-body">
                <p class="delete-text">هل تريد تفعيل <strong></strong></p>
            </section>
            <footer class="modal-card-foot">
                <button type="submit" class="button is-success">تأكيد</button>
                <button class="button close-modal">الغاء</button>
            </footer>
        </form>
    </div>
</div>
