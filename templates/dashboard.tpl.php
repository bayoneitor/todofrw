<?php
include 'templates/header.tpl.php';
?>
<main>
    <article>
        <h2 class="text-center" style="margin-top: 20px;"><?= $title; ?></h2>
    </article>
    <?php
    switch ($action) {
        case 'add':
    ?>
            <div id="formulario">
                <h1>AÑADIR TAREA</h1>
                <form action="<?= $web ?>dashboard/action" method="post">
                    <input type="text" name="description" placeholder="Descripción Tarea">
                    <input type="date" name="date" value="<?= date("Y-m-d") ?>">
                    <input type="submit" value="Añadir" name="add-button" class="btn btn-success">
                </form>
                <a href="<?= $web ?>dashboard" class="btn btn-danger">Cancelar</a>
            </div>

        <?php
            break;
        case 'remove':
            $tarea = "";
            foreach ($tasks as $task) {
                foreach ($task as $key => $value) {
                    if ($key == "id") {
                        $idTask = $value;
                    } else {
                        $tarea .= $value . ", ";
                    }
                }
            }
            $tarea = substr($tarea, 0, -11);
        ?>
            <div id="formulario" style="height: 300px;">
                <h1>ELIMINAR TAREA</h1>
                <p class="text-center" style="color: #cecece;">¿Estás seguro que deseas eliminar la tarea? <br> Borrarás la siguiente tarea: <br> <b><?= $tarea ?></b></p>

                <div class="flex" style="justify-content:center;align-items:center;">
                    <form action="<?= $web ?>dashboard/action" method="post">
                        <input type="hidden" name="idTask" value="<?= $idTask ?>">
                        <input type="submit" name="remove-button" value="Sí" class="btn btn-success">
                    </form>
                    <a href="<?= $web ?>dashboard" class="btn btn-danger">No</a>
                </div>
            </div>

        <?php
            break;
        case 'edit':
            foreach ($tasks as $task) {
                foreach ($task as $key => $value) {
                    if ($key == "id") {
                        $idTask = $value;
                    } else if ($key == "description") {
                        $desc = $value;
                    } else if ($key == "due_date") {
                        $date = $value;
                    }
                }
            }
            $date = substr($date, 0, -9);
        ?>
            <div id="formulario">
                <h1>EDITAR TAREA</h1>
                <form action="<?= $web ?>dashboard/action" method="post">
                    <input type="text" name="description" placeholder="Descripción Tarea" value="<?= $desc ?>">
                    <input type="date" name="date" placeholder="yyyy-mm-dd" value="<?= $date ?>">

                    <!-- Pasamos la id por hidden ya que es un formulario -->
                    <input type="hidden" name="idTask" value="<?= $idTask ?>">
                    <input type="submit" value="Actualizar" name="edit-button" class="btn btn-success">
                </form>
                <a href="<?= $web ?>dashboard" class="btn btn-danger">Cancelar</a>
            </div>

        <?php
            // Primero (index)
            break;
        default:
        ?>
            <section style="margin: 50px auto;width:85%;">
                <table class="table table-hover table-dark" id="table">
                    <a href="<?= $web ?>dashboard/add" id="add">+</a>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descripción Tarea</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($tasks as $task) {
                            echo '<tr>';
                            foreach ($task as $key => $value) {
                                if ($key == "id") {
                                    $idTask = $value;
                                    echo "<td>$i</td>";
                                } else if ($key == "due_date") {
                                    echo '<td>' . substr($value, 0, -9) . '</td>';
                                } else {
                                    echo "<td>$value</td>";
                                }
                            }
                            echo '<td>

                                    <a href="' . $web . 'dashboard/edit/id/' . $idTask . '">
                                        <svg id="edit" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path d="M496.063,62.299l-46.396-46.4c-21.199-21.199-55.689-21.198-76.888,0C352.82,35.86,47.964,340.739,27.591,361.113 c-2.17,2.17-3.624,5.054-4.142,7.875L0.251,494.268c-0.899,4.857,0.649,9.846,4.142,13.339c3.497,3.497,8.487,5.042,13.338,4.143	L143,488.549c2.895-0.54,5.741-2.008,7.875-4.143l345.188-345.214C517.311,117.944,517.314,83.55,496.063,62.299z M33.721,478.276 l14.033-75.784l61.746,61.75L33.721,478.276z M140.269,452.585L59.41,371.721L354.62,76.488l80.859,80.865L140.269,452.585z M474.85,117.979l-18.159,18.161l-80.859-80.865l18.159-18.161c9.501-9.502,24.96-9.503,34.463,0l46.396,46.4 C484.375,93.039,484.375,108.453,474.85,117.979z" />
                                                </g>
                                            </g>
                                        </svg></a>
                                    <a href="' . $web . 'dashboard/remove/id/' . $idTask . '">
                                        <svg id="remove" enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="m424 64h-88v-16c0-26.467-21.533-48-48-48h-64c-26.467 0-48 21.533-48 48v16h-88c-22.056 0-40 17.944-40 40v56c0 8.836 7.164 16 16 16h8.744l13.823 290.283c1.221 25.636 22.281 45.717 47.945 45.717h242.976c25.665 0 46.725-20.081 47.945-45.717l13.823-290.283h8.744c8.836 0 16-7.164 16-16v-56c0-22.056-17.944-40-40-40zm-216-16c0-8.822 7.178-16 16-16h64c8.822 0 16 7.178 16 16v16h-96zm-128 56c0-4.411 3.589-8 8-8h336c4.411 0 8 3.589 8 8v40c-4.931 0-331.567 0-352 0zm313.469 360.761c-.407 8.545-7.427 15.239-15.981 15.239h-242.976c-8.555 0-15.575-6.694-15.981-15.239l-13.751-288.761h302.44z" />
                                                <path d="m256 448c8.836 0 16-7.164 16-16v-208c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z" />
                                                <path d="m336 448c8.836 0 16-7.164 16-16v-208c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z" />
                                                <path d="m176 448c8.836 0 16-7.164 16-16v-208c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z" />
                                            </g>
                                        </svg>
                                    </a>
                                </td> </tr>';
                            $i++;
                        }
                        ?>

                    </tbody>
                </table>
            </section>
    <?php
            break;
    }
    ?>

</main>
<?php
include 'templates/footer.tpl.php';
