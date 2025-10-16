<?php

namespace Application\Domain\Stadium\UseCase;

use \InvalidArgumentException;
use Exception;
use Application\Domain\Stadium\StadiumRepositoryInterface;
use Application\Domain\Stadium\ValueObject\StadiumName;
use Application\Domain\Stadium\ValueObject\StadiumId;

class UpdateStadiumUseCase
{
    public function __construct(
        private StadiumRepositoryInterface $stadiumRepository
    ) {
    }

    /**
     * 球場の登録
     * @param UpdateStadiumInput $input
     * @return void
     */
    public function process(UpdateStadiumInput $input): void
    {
        try {
            // 入力値の検証
            $stadiumId = new StadiumId($input->getId());
            $stadium = $this->stadiumRepository->getStadiumById($stadiumId);

            if ($stadium === null) {
                throw new InvalidArgumentException('Stadium not found');
            }
        } catch (InvalidArgumentException $e) {
            // 例外をキャッチして適切な処理を行う
            throw $e;
        } catch (Exception $e) {
            // 例外をキャッチして適切な処理を行う
            throw $e;
        }

        // 球場名の更新
        $stadium->setName(new StadiumName($input->getName()));
    

        try {
            // 球場を保存
            $this->stadiumRepository->save($stadium);
        } catch (\Exception $e) {
            // 保存に失敗した場合の処理
            throw $e;
        }
        
    }
}