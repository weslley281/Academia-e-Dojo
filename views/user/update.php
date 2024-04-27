<div class="container mt-5">
    <h1>Editar Usuário</h1>
    <form action="./user.php?action=update" method="post" class="form-group">
        <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
        <div class="mb-3 form-group">
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $user["name"] ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label"><strong>Email:</strong></label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $user["email"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="phone" class="form-label"><strong>Telefone:</strong></label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $user["phone"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="address" class="form-label"><strong>Endereço:</strong></label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo $user["address"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="complement" class="form-label"><strong>Complemento:</strong></label>
            <input type="text" id="complement" name="complement" class="form-control" value="<?php echo $user["complement"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="country" class="form-label"><strong>País:</strong></label>
            <input type="text" id="country" name="country" class="form-control" value="Brasil" readonly required>
        </div>

        <div class="mb-3 form-group">
            <label for="state" class="form-label">Selecione o Estado</label>
            <select class="form-control" class="form-select" id="state" name="state" required>
                <option value="">Selecione um estado</option>
                <?php
                $states = array(
                    'AC' => 'Acre',
                    'AL' => 'Alagoas',
                    'AP' => 'Amapá',
                    'AM' => 'Amazonas',
                    'BA' => 'Bahia',
                    'CE' => 'Ceará',
                    'DF' => 'Distrito Federal',
                    'ES' => 'Espírito Santo',
                    'GO' => 'Goiás',
                    'MA' => 'Maranhão',
                    'MT' => 'Mato Grosso',
                    'MS' => 'Mato Grosso do Sul',
                    'MG' => 'Minas Gerais',
                    'PA' => 'Pará',
                    'PB' => 'Paraíba',
                    'PR' => 'Paraná',
                    'PE' => 'Pernambuco',
                    'PI' => 'Piauí',
                    'RJ' => 'Rio de Janeiro',
                    'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul',
                    'RO' => 'Rondônia',
                    'RR' => 'Roraima',
                    'SC' => 'Santa Catarina',
                    'SP' => 'São Paulo',
                    'SE' => 'Sergipe',
                    'TO' => 'Tocantins'
                );

                foreach ($states as $code => $name) {
                    $selected = ($user['state'] === $code) ? 'selected' : '';
                    echo "<option value=\"$code\" $selected>$name</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="city" class="form-label"><strong>Cidade:</strong></label>
            <input type="text" id="city" name="city" class="form-control" value="<?php echo $user["city"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="neighborhood" class="form-label"><strong>Bairro:</strong></label>
            <input type="text" id="neighborhood" name="neighborhood" class="form-control" value="<?php echo $user["neighborhood"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="postalCode" class="form-label"><strong>CEP:</strong></label>
            <input type="text" id="postalCode" name="postalCode" class="form-control" value="<?php echo $user["postalCode"] ?>" required>
        </div>

        <div class="mb-3 form-group">
            <label for="maritalStatus" class="form-label"><strong>Estado Civil:</strong></label>
            <select class="form-control" name="maritalStatus" id="maritalStatus" required>
                <?php
                $marital_statuses = [
                    'single' => 'Solteiro',
                    'married' => 'Casado',
                    'divorced' => 'Divorciado',
                    'widower' => 'Viúvo',
                ];

                foreach ($marital_statuses as $status => $label) {
                    $selected = ($user['maritalStatus'] === $status) ? 'selected' : '';
                    echo "<option value=\"$status\" $selected>$label</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="gender" class="form-label"><strong>Gênero:</strong></label>
            <select class="form-control" name="gender" id="gender" required>
                <?php
                $genders = [
                    'masculine' => 'Masculino',
                    'feminine' => 'Feminino',
                    'non-binary' => 'Não-Binário',
                    'gender-fluid' => 'Gênero-Fluido',
                    'transgender' => 'Transgênero',
                    'agender' => 'Agênero',
                    'two-spirit' => 'Dois Espíritos',
                    'other' => 'Outro',
                    'null' => 'Prefiro não dizer',
                ];

                foreach ($genders as $gender => $label) {
                    $selected = ($user['gender'] === $gender) ? 'selected' : '';
                    echo "<option value=\"$gender\" $selected>$label</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="isMinor" class="form-label"><strong>É menor de Idade:</strong></label>
            <div>
                <div class="form-check">
                    <?php
                    // Determine qual valor é o correto com base no retorno de $user["isMinor"]
                    $is_minor = ($user["isMinor"] == 1) ? true : false;
                    ?>
                    <input class="form-check-input" type="radio" name="isMinor" id="not_minor" value="0" <?php echo !$is_minor ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="not_minor">
                        Não é menor de idade
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="isMinor" id="is_minor" value="1" <?php echo $is_minor ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="is_minor">
                        É menor de idade
                    </label>
                </div>
            </div>
        </div>


        <div class="mb-3 form-group">
            <label for="birthDate" class="form-label"><strong>Data de Nascimento:</strong></label>
            <input type="date" id="birthDate" name="birthDate" class="form-control" value="<?php echo $user["birthDate"] ?>" required>
        </div>

        <div class="row">
            <div class="col"><button type="submit" class="mb-3 btn btn-secondary float-left">Salvar</button></div>
            <div class="col"><a href="./index.php?page=users" class="btn btn-light float-right">Cancelar</a></div>
        </div>


    </form>
</div>