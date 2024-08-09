const bcrypt = require('bcrypt');

const senha = '1234';

bcrypt.hash(senha, 10, (err, hash) => {
    if (err) {
        console.error('Erro ao criptografar a senha:', err);
        return;
    }
    console.log('Senha criptografada:', hash);
});
