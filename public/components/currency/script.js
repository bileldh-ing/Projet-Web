const convertButton = document.getElementById("convertButton");
const amountInput = document.getElementById("amount");
const fromCurrencySelect = document.getElementById("fromCurrency");
const toCurrencySelect = document.getElementById("toCurrency");
const conversionResult = document.getElementById("conversionResult");

// Currency codes and their flag emojis via Unicode
const currencyFlags = {
  USD: "🇺🇸", // US Dollar
  EUR: "🇪🇺", // Euro
  GBP: "🇬🇧", // British Pound
  JPY: "🇯🇵", // Japanese Yen
  AUD: "🇦🇺", // Australian Dollar
  CAD: "🇨🇦", // Canadian Dollar
  CHF: "🇨🇭", // Swiss Franc
  CNY: "🇨🇳", // Chinese Yuan
  INR: "🇮🇳", // Indian Rupee
  BRL: "🇧🇷", // Brazilian Real
  MXN: "🇲🇽", // Mexican Peso
  ZAR: "🇿🇦", // South African Rand
  SEK: "🇸🇪", // Swedish Krona
  NOK: "🇳🇴", // Norwegian Krone
  RUB: "🇷🇺", // Russian Ruble
  KZT: "🇰🇿", // Kazakhstan Tenge
  TND: "🇹🇳", // Tunisian Dinar
};

// Dynamically populate dropdowns
function populateCurrencyDropdowns() {
  for (const [code, flag] of Object.entries(currencyFlags)) {
    const optionFrom = document.createElement("option");
    const optionTo = document.createElement("option");

    optionFrom.value = code;
    optionTo.value = code;

    // Add the flag and currency code
    optionFrom.textContent = `${flag} ${code}`;
    optionTo.textContent = `${flag} ${code}`;

    fromCurrencySelect.appendChild(optionFrom);
    toCurrencySelect.appendChild(optionTo);
  }
}

// Initialize dropdowns
populateCurrencyDropdowns();

// API key from ExchangeRate-API or Fixer.io
const apiKey = "e500c361b06d245907dacbb1"; // Replace with your API key

convertButton.addEventListener("click", convertCurrency);

async function convertCurrency() {
  const amount = amountInput.value;
  const fromCurrency = fromCurrencySelect.value;
  const toCurrency = toCurrencySelect.value;

  if (!amount || amount <= 0) {
    alert("Please enter a valid amount.");
    return;
  }

  const url = `https://api.exchangerate-api.com/v4/latest/${fromCurrency}`;

  try {
    const response = await fetch(url);
    const data = await response.json();

    if (data.error) {
      alert("Error retrieving currency data.");
      return;
    }

    const conversionRate = data.rates[toCurrency];
    const convertedAmount = (amount * conversionRate).toFixed(2);

    conversionResult.textContent = `${amount} ${fromCurrency} = ${convertedAmount} ${toCurrency}`;
  } catch (error) {
    alert("Error fetching data from the API.");
  }
}
