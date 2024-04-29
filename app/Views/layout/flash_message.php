<!-- Error Alert -->
<div class="position-fixed mx-auto my-2" style="bottom: 0; right: 0; left: 0; z-index: 1050; max-width: 90%; max-height: 60%;">

    <?php if(session()->has('errors')): ?>
        <div class="alert alert-danger alert-dismissible mt-1 mb-0" role="alert">
            <div>
                <strong>Error:</strong>
                <ul class="my-0">
                    <?php foreach(session()->get('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
  </button>
        </div>
    <?php endif ?>

    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible mt-1 mb-0" role="alert">
            <div>
                <strong>Error:</strong>
                <div><?= session()->get('error') ?></div>
            </div>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </div>
    <?php endif ?>

    <?php if(session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible mt-1 mb-0" role="alert">
            <div>
                <strong>Success:</strong>
                <div><?= session()->get('success') ?></div>
            </div>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </div>
    <?php endif ?>

</div>