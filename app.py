from flask import Flask, request, jsonify
import requests
import os

app = Flask(__name__)

@app.route("/api/buscar")
def buscar():
    parametros = request.args.to_dict()
    url_api_gov = "https://api.portaldecompras.gov.br/licitacoes?" + "&".join([f"{k}={v}" for k, v in parametros.items()])
    try:
        response = requests.get(url_api_gov)
        return jsonify(response.json())
    except Exception as e:
        return jsonify({"erro": "Falha ao acessar API do GOV", "detalhes": str(e)}), 500

if __name__ == "__main__":
    port = int(os.environ.get("PORT", 10000))
    app.run(host="0.0.0.0", port=port)