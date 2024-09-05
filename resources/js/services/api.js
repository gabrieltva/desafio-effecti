/**
 * Recupera todos os usuários
 * @returns {array}
 */
export const getAllUser = async () => {
  const response = await fetch(import.meta.env.VITE_API_USER, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error("Erro ao tentar recuperar usuários");
  }

  return data;
}

/**
 * Registra um usuário
 * @param {object} user 
 */
export const registerUser = async (user) => {
  const response = await fetch(import.meta.env.VITE_API_USER, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(user)
  });

  if (!response.ok) {
    throw new Error("Erro ao tentar registrar usuário");
  }
}

/**
 * Recupera um usuário
 * @param {int} id 
 * @returns {object}
 */
export const getUser = async (id) => {
  const response = await fetch(`${import.meta.env.VITE_API_USER}/${id}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error("Erro ao tentar recuperar usuário");
  }

  return data;
}

/**
 * Atualiza um usuário
 * @param {object} user 
 */
export const updateUser = async (id, user) => {
  const response = await fetch(`${import.meta.env.VITE_API_USER}/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(user)
  });

  if (!response.ok) {
    throw new Error("Erro ao tentar atualizar usuário");
  }
}

/**
 * Deleta um usuário
 * @param {int} id 
 */
export const deleteUser = async (id) => {
  const response = await fetch(`${import.meta.env.VITE_API_USER}/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  if (!response.ok) {
    throw new Error("Erro ao tentar deletar usuário");
  }
}

/**
 * Recupera dados de endereço a partir do CEP
 * @param {string} cep 
 */
export const getAddressByCep = async (cep) => {
  const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
  const data = await response.json()

  if (!response.ok) {
    throw new Error("Erro ao tentar recuperar endereço");
  }

  return data;
}