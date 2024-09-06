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

/**
 * Convert date format from "YYYY-MM-DD" to "DD/MM/YYYY"
 * @param date The date in "YYYY-MM-DD" format
 * @returns The date in "DD/MM/YYYY" format
 */
export const convertDateFormatToFront = (date: string): string => {
  const [year, month, day] = date.split("-");
  return `${day}/${month}/${year}`;
};

/**
 * Convert date format from "DD/MM/YYYY" to "YYYY-MM-DD"
 * @param date The date in "DD/MM/YYYY" format
 * @returns The date in "YYYY-MM-DD" format
 */
export const convertDateFormatToBack = (date: string): string => {
  const [day, month, year] = date.split("/");
  return `${year}-${month}-${day}`;
}

/**
 * Convert the errors object into a single error message string
 * @param errors The errors object
 * @returns The error message string
 */
export const formatErrorMessage = (errors: any): string => {
  console.log(errors.errors);
  let errorMessage = "";
  for (const field in errors.errors) {
    const fieldErrors = errors.errors[field];
    errorMessage += `${fieldErrors.join("\n")}\n`;
  }
  return errorMessage.trim();
};