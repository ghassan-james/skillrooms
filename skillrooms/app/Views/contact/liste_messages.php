<div class="container mt-4">

    <h2>Messages des visiteurs</h2>
    <hr>

    <?php if (empty($messages)) : ?>
        <div class="alert alert-info">Aucune demande de visiteur pour le moment !</div>
    <?php else : ?>

        <table class="table table-bordered table-striped shadow">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>État</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($messages as $m) : ?>
                    <tr class="<?= empty($m['msg_reponse']) ? 'table-warning' : '' ?>">

                        <td><?= $m['msg_date'] ?></td>
                        <td><?= esc($m['msg_email']) ?></td>
                        <td><?= esc($m['msg_titre']) ?></td>

                        <td>
                            <?php if (empty($m['msg_reponse'])) : ?>
                                <span class="badge bg-danger">Non répondu</span>
                            <?php else : ?>
                                <span class="badge bg-success">Répondu</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?= base_url('index.php/admin/contact/voir/'.$m['msg_id']) ?>"
                               class="btn btn-sm btn-primary">
                                Répondre
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>
