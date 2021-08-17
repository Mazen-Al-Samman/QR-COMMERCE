@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper text-center mt-5">
                        <h1>نعتذر .. لا يوجد لديك أيّة صلاحيات</h1>
                        <p>يمكنك التواصل مع منظمتك لمزيد من المعلومات</p>

                        <h1 class="mt-5">Sorry .. you don't have any permissions</h1>
                        <p>Please contact with your organization for more information</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include ('backend.layouts.footer')
