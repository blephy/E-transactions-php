export const REF_REG_EXP = /^[a-z]\d{2}[/.-]\d{5}$/i; // Format E17/12345
export const REF_REG_EXP_WITHOUT = /^[a-z]\d{7}$/i; // Format E1712345
export const DDN_REG_EXP = /^\d{2}[/.-]\d{2}[/.-]\d{4}$/i; // Format 31/12/1987
export const DDN_REG_EXP_WITHOUT = /^\d{8}$/i; // Format 31121987
export const MAIL_REG_EXP = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/i;
export const REMOVE_WHITE_SPACE = / /g;
