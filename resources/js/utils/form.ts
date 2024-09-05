import { getAddressByCep } from "@/services/api";
import { Ref } from "vue";

/**
 * Fill the address data based on the given CEP
 * @param cep 
 * @returns 
 */
export const fillAddressDataByCEP = async (cep: string, isLoadingCep: Ref<boolean, boolean>) => {
  if (cep.length !== 9) {
    return
  }
  
  isLoadingCep.value = true

  try {
    const data = await getAddressByCep(cep);
    return data
  }
  catch (error) {
    console.error(error);
    return null
  }
  finally {
    isLoadingCep.value = false
  }
}

/**
 * array of brazilian states
 */
export const statesField = [
  "AC",
  "AL",
  "AP",
  "AM",
  "BA",
  "CE",
  "DF",
  "ES",
  "GO",
  "MA",
  "MT",
  "MS",
  "MG",
  "PA",
  "PB",
  "PR",
  "PE",
  "PI",
  "RJ",
  "RN",
  "RS",
  "RO",
  "RR",
  "SC",
  "SP",
  "SE",
  "TO"
]