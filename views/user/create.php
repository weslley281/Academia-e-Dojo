<div class="container mt-5">
    <h1>Criar Usuário</h1>
    <form action="./controllers/UserController.php?action=create" method="post" class="form-group">
        <div class="mb-3 form-group">
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label"><strong>Email:</strong></label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label"><strong>Senha:</strong></label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password2" class="form-label"><strong>Repita a Senha:</strong></label>
            <input type="password" id="password2" name="password2" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="phone" class="form-label"><strong>Telefone:</strong></label>
            <input type="text" id="phone" name="phone" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="cpf" class="form-label"><strong>CPF:</strong></label>
            <input type="text" id="cpf" name="cpf" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="address" class="form-label"><strong>Endereço:</strong></label>
            <input type="text" id="address" name="address" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="complement" class="form-label"><strong>Complemento:</strong></label>
            <input type="text" id="complement" name="complement" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="country" class="form-label"><strong>País:</strong></label>
            <input type="text" id="country" name="country" class="form-control" value="Brasil" readonly required>
        </div>

        <div class="mb-3 form-group">
            <label for="state" class="form-label">Selecione o Estado</label>
            <select class="form-control" class="form-select" id="state" name="state">
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="city" class="form-label"><strong>Cidade:</strong></label>
            <input type="text" id="city" name="city" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="neighborhood" class="form-label"><strong>Bairro:</strong></label>
            <input type="text" id="neighborhood" name="neighborhood" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="postalCode" class="form-label"><strong>CEP:</strong></label>
            <input type="text" id="postalCode" name="postalCode" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="maritalStatus" class="form-label"><strong>Estádo Civil:</strong></label>
            <select class="form-control" name="maritalStatus" id="maritalStatus" required>
                <option value="single">Solteiro</option>
                <option value="married">Casado</option>
                <option value="divorced">Divorciado</option>
                <option value="widower">Viúvo</option>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="gender" class="form-label"><strong>Genêro:</strong></label>
            <select class="form-control" name="gender" id="gender">
                <option value="masculine">Masculino</option>
                <option value="feminine">Feminino</option>
                <option value="non-binary">Não-Binário</option>
                <option value="gender-fluid">Gênero-Fluido</option>
                <option value="rransgender">Transgênero</option>
                <option value="agender">Agênero</option>
                <option value="two-spirit">Dois Espíritos</option>
                <option value="other">Outro</option>
                <option value="null">Prefiro não dizer</option>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="birthDate" class="form-label"><strong>Data de Nascimento:</strong></label>
            <input type="date" id="birthDate" name="birthDate" class="form-control" required>
        </div>

        <div class="row">
            <div class="col"><button type="submit" class="mb-3 btn btn-success float-left">Criar</button></div>
            <div class="col"><a href="./index.php?page=users" class="btn btn-light float-right">Cancelar</a></div>
        </div>
    </form>
</div>
