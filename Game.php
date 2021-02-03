<?php
final class Game
{	
	private const BASE_URL = 'https://code-challenge.webandcow.com/';

	private $codeEngine;
	private $key;
	private $token;

	public function __construct(string $key, string $codeEngine)
	{
		$this->key = $key;
		$this->codeEngine = $codeEngine;
	}

	public function getDatasGame(): array
	{
		$data = $this->requestApi('games/launch/' . $this->key . '/' . $this->codeEngine);
		$this->token = $data['token'];

		$data = $this->requestApi('games/init/' . $this->token);

		return $data['game'];
	}

	public function push(array $dataPlayer): void
	{
		if (!isset($dataPlayer['reponse'])) {
			$this->errors(['Votre tableau de retour doit contenir une cle "reponse"']);
		}

		$dataPlayer = base64_encode(json_encode($dataPlayer));
		
		$data = $this->requestApi('games/push/' . $this->token . '/' . $dataPlayer);

		$color = $data['success_game'] ? 'green' : 'red';

		echo '<p><b style="color: ' . $color . ';">' . $data['message'] . '</b></p>' .
			 '<p><b>Le Token de ta Game :</b> <a href="' . self::BASE_URL . 'games/story/' . $this->token . '" target="_blank">' . $this->token . '</a></p>';
	}

	private function requestApi(string $url): array
	{
        $data = file_get_contents(self::BASE_URL . $url);
		$data = json_decode($data, true);

		if (!$data['success']) {
			$this->errors($data['errors']);
		}

		assert(isset($data['data']));
		return $data['data'];
	}

	private function errors($errors): void
	{
		foreach ((array) $errors as $error) {
			echo '<p><b>Erreur : </b> ' . $error . '</p>';
		}

		exit();
	}
}